<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;
use Illuminate\Support\Facades\Http;

class MoveLocalCourseImageToS3 extends Command
{
    protected $signature = 'course-image:move-to-s3';
    protected $description = 'Move all locally stored videos to Amazon S3 and update their database paths';

    public function handle()
    {
        ini_set('memory_limit', '1G'); // increase memory just in case
        set_time_limit(0);             // disable max execution time

        $this->info('🚀 Starting migration of local videos to S3...');
        $moved = 0;

        $videos = Course::query()
            //->where('id', '399') // for testing single video
            //->whereNull('aws_url')
            ->whereNotNull('course_image')
            ->chunk(20, function ($datas) use (&$moved) {
                foreach ($datas as $row) {


                    $localPath = trim($row->course_image);

                    if (empty($localPath)) {
                        $this->warn("⚠️ Skipped: Empty URL for Course ID {$row->id}");
                        continue;
                    }

                    try {
                        $fileName = $row->course_image; // original file name
                        $remoteUrl = "https://academy.delta-medlab.com/storage/uploads/{$fileName}";

                        // Download file from remote server
                        $fileContents = @file_get_contents($remoteUrl);

                        if ($fileContents === false) {
                            throw new \Exception("Unable to download file: {$remoteUrl}");
                        }

                        // Detect MIME type
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mimeType = finfo_buffer($finfo, $fileContents);
                        finfo_close($finfo);

                        // Path to upload in S3
                        $s3Path = "uploads/{$fileName}";

                        $this->info("☁️ Uploading to S3: {$s3Path}");

                        // Upload file to S3
                        Storage::disk('s3')->put($s3Path, $fileContents, [
                            'visibility'   => 'private',
                            'ContentType'  => $mimeType,
                        ]);

                        // Generate temporary URL
                        $s3Url = Storage::disk('s3')->temporaryUrl(
                            $s3Path,
                            now()->addMinutes(60)
                        );

                        $row->course_image = $s3Path;
                        $row->save();

                    } catch (\Throwable $e) {
                        $this->error("❌ Error with {$fileName}: " . $e->getMessage());
                    }
                }
            });

        $this->info("🎉 Migration complete. {$moved} files successfully uploaded to S3.");
    }
}
