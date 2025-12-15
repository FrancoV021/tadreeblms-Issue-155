<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourseRequest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'course_id', 'city'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
