<?php

namespace App\Jobs;

use App\Exports\InternalAttendanceReportExport;
use App\Models\ExportInternalReportNotification;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Excel as ExcelFormat;



class GenerateInternalAttendanceReport implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $params;


    public function __construct($params)
    {
        $this->params = $params;
    }



    public function handle()
    {
        try {
            $fileName = 'internal_report_' . time() . '.csv';
            $folderPath = public_path('reports');
            $fullPath = $folderPath . DIRECTORY_SEPARATOR . $fileName;

            // Create directory if it doesn't exist
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }

            // Optional: Delete old CSV files
            foreach (File::files($folderPath) as $file) {
                if (str_ends_with($file->getFilename(), '.csv')) {
                    File::delete($file->getPathname());
                }
            }

            // Generate CSV content
            $csvContent = Excel::raw(new InternalAttendanceReportExport($this->params), ExcelFormat::CSV);

            // Save the CSV file
            File::put($fullPath, $csvContent);

            // Generate public download URL
            $downloadUrl = asset('reports/' . $fileName);

            // Update the database with download link
            ExportInternalReportNotification::query()
                ->where('user_id', $this->params['logged_user_id'])
                ->update([
                    'download_link' => $downloadUrl,
                    'status' => 1,
                ]);

            // Notify admins via email
            $emails = explode(',', env('EMAIL_ADMIN_REPORT', ''));
            foreach ($emails as $email) {
                if (!empty($email)) {
                    dispatch(new SendEmailJob([
                        'to_name' => '',
                        'to_email' => $email,
                        'subject' => 'Internal Attendance Report',
                        'html' => 'You can download the report from here <a href="' . $downloadUrl . '" download>Download</a>',
                    ]));
                }
            }
        } catch (\Exception $e) {
            // Log error or notify
            //\Log::error("CSV export failed: " . $e->getMessage());

            // Update DB with error info
            ExportInternalReportNotification::query()
                ->where('user_id', $this->params['logged_user_id'])
                ->update([
                    'download_link' => 'Error: ' . $e->getMessage(),
                    'status' => 1,
                ]);

            // Send error email
            dispatch(new SendEmailJob([
                'to_name' => '',
                'to_email' => 'anupdeveloper07@gmail.com',
                'subject' => 'Internal Attendance Report Error',
                'html' => 'Error: ' . $e->getMessage(),
            ]));
        }
    }
}
