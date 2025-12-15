<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportInternalReportNotification extends Model
{
    protected $table = 'export_internal_report_notification';
    protected $fillable = [
        'user_id', 
        'status',
        'download_link'
    ];

    
}
