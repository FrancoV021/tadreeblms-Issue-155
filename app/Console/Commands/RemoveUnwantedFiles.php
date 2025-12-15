<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveUnwantedFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:unwanted-uploads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove unwanted files from /storage/uploads directory by checking against the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting cleanup process...');

        // Directory to scan
        $uploadsDir = public_path('/storage/uploads/');

        // Ensure directory exists
        if (!File::exists($uploadsDir)) {
            $this->error("The directory $uploadsDir does not exist.");
            return Command::FAILURE;
        }

        // Allowed video formats
        $allowedExtensions = ['mp4', 'mkv', 'avi', 'mov', 'flv', 'wmv', 'webm'];

        // Get all files in the directory
        $files = File::files($uploadsDir);

        // Gather valid file names from multiple tables
        $validFiles = collect();

        // Add file names from each table and column
        $tablesToCheck = [
            ['table' => 'media', 'column' => 'file_name'],
        ];

        foreach ($tablesToCheck as $entry) {
            $validFiles = $validFiles->merge(
                DB::table($entry['table'])->pluck($entry['column'])
            );
        }

        $validFiles = $validFiles->unique()->toArray();

        $deletedFiles = 0;

        foreach ($files as $file) {
            $fileExtension = $file->getExtension();

            // Check if the file is a video and not in the valid files list
            if (in_array($fileExtension, $allowedExtensions) && !in_array($file->getFilename(), $validFiles)) {
                // Delete file if not valid
                File::delete($file->getRealPath());
                $this->info("Deleted: " . $file->getFilename());
                $deletedFiles++;
            }
        }

        $this->info("Cleanup complete. $deletedFiles video file(s) deleted.");
        return Command::SUCCESS;
    }
}
