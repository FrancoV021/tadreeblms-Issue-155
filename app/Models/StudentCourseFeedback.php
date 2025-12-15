<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCourseFeedback extends Model
{
    protected $table = "student_course_feedback";
    protected $guarded = [];

    
    public function student()
    {
        return $this->belongsTo(Auth\User::class,'user_id');
    }

}
