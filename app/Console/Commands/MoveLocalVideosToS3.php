<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;
use Illuminate\Support\Facades\Http;

class MoveLocalVideosToS3 extends Command
{
    protected $signature = 'videos:move-to-s3';
    protected $description = 'Move all locally stored videos to Amazon S3 and update their database paths';

    public function handle()
    {
        ini_set('memory_limit', '1G'); // increase memory just in case
        set_time_limit(0);             // disable max execution time

        $this->info('🚀 Starting migration of local videos to S3...');
        $moved = 0;

        $videos = Media::query()
            //->where('id', '4719') // for testing single video
            ->whereNull('aws_url')
            ->whereNotNull('url')
            ->chunk(20, function ($videos) use (&$moved) {
                foreach ($videos as $video) {

                    // Skip YouTube or embed videos
                    if (in_array($video->type, ['youtube', 'embed'])) {
                        continue;
                    }

                    $localPath = trim($video->oldurl);

                    if (empty($localPath)) {
                        $this->warn("⚠️ Skipped: Empty URL for media ID {$video->id}");
                        continue;
                    }

                    try {
                        // Determine MIME type
                        $extension = strtolower(pathinfo($localPath, PATHINFO_EXTENSION));

                        if ($extension === 'mp4') {
                            $mimeType = 'video/mp4';
                        } elseif ($extension === 'mp3') {
                            $mimeType = 'audio/mpeg';
                        } elseif ($extension === 'mov') {
                            $mimeType = 'video/quicktime';
                        } elseif ($extension === 'm4a') {
                            $mimeType = 'audio/mp4';
                        } else {
                            $mimeType = 'application/octet-stream'; // fallback
                        }

                        // Build file and S3 paths
                        $fileName = time() . '-' . uniqid() . '.' . $extension;
                        $s3Path = "staging/{$fileName}";

                        // Stream to temporary file (avoids memory overflow)
                        $tempPath = storage_path("app/temp_{$fileName}");

                        $this->info("⬇️ Downloading: {$localPath}");

                        Http::timeout(600) // 10 minutes
                            ->withHeaders(['User-Agent' => 'LaravelUploader/1.0'])
                            ->withOptions(['sink' => $tempPath])
                            ->get($localPath);

                        // Verify file downloaded
                        if (!file_exists($tempPath) || filesize($tempPath) === 0) {
                            $this->error("❌ Download failed or empty file for: {$localPath}");
                            @unlink($tempPath);
                            continue;
                        }

                        $this->info("☁️ Uploading to S3: {$s3Path}");

                        // Upload to S3 using stream
                        Storage::disk('s3')->put($s3Path, fopen($tempPath, 'r'), [
                            'visibility' => 'private',
                            'ContentType' => $mimeType,
                        ]);

                        // Save new AWS path in DB
                        $video->aws_url = $s3Path;
                        $video->save();

                        $this->info("✅ Uploaded: {$s3Path}");

                        // Delete temp file
                        @unlink($tempPath);

                        $moved++;
                    } catch (\Throwable $e) {
                        $this->error("❌ Error with {$localPath}: " . $e->getMessage());
                    }
                }
            });

        $this->info("🎉 Migration complete. {$moved} files successfully uploaded to S3.");
    }


}
