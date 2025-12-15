<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class AttendanceStudent extends Model
{
    use SoftDeletes;

    protected $table = 'attendance_student';
    protected $fillable = ['student_id', 'course_id', 'lesson_id'];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class,'lesson_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User','student_id');
    }
}
