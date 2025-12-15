<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;
    protected $table = 'assignments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_id',
        'user_id',
        'verify_code',
        'url_code',
        'total_question',
        'user_type',
        'duration',
        'start_time',
        'end_time',
        'buffer_time',
        'is_started'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function assignmentQuestions()
    {
        return $this->hasMany(AssignmentQuestion::class, 'assessment_test_id', 'id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id');
    }
}
