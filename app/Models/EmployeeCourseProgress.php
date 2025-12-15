<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeCourseProgress extends Model
{

    protected $table = 'employee_course_progress';
    protected $fillable = [
        'user_id', 
        'course_id',
        'is_cron_run',
        'created_at'
    ];

    
}
