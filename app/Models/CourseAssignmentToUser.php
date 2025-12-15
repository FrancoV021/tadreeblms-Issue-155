<?php

namespace App\Models;

use App\Models\Auth\User;
use App\Models\Stripe\SubscribeCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseAssignmentToUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'course_assignment_users';
    protected $fillable = [
        'created_at',
        'course_assignment_id',
        'course_id',
        'user_id',
        'log_comment',
        'updated_at',
        'by_pathway',
        'by_invitation'
    ];


    /*
    protected static function booted()
    {
        static::retrieved(function ($model) {
            // If already loaded via with('assignment'), replace with correct instance
            if (array_key_exists('assignment', $model->relations)) {
                $model->setRelation(
                    'assignment',
                    $model->by_pathway == 1
                        ? $model->assignmentPathway
                        : $model->assignmentNormal
                );
            }
        });
    }
    */

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function assignmentNormal()
    // {
    //     return $this->belongsTo(CourseAssignment::class, 'course_assignment_id');
    // }

    public function assignmentPathway()
    {
        return $this->belongsTo(LearningPathwayAssignment::class, 'course_assignment_id');
    }

    // public function getAssignmentAttribute()
    // {
    //     if ($this->by_pathway == 1) {
    //         return $this->assignmentPathway()->first();
    //     }

    //     return $this->assignmentNormal()->first();
    // }

    // public function assignment()
    // {
    //     // Return a belongsTo just for Eloquent compatibility (so with() works)
    //     return $this->belongsTo(CourseAssignment::class, 'course_assignment_id')
    //         ->select('*') // select everything
    //         ->withDefault()
    //         ->whereRaw('1=0'); // never actually runs, just allows with('assignment') to pass
    // }

    public function assignment()
    {
       return $this->belongsTo(courseAssignment::class, 'course_assignment_id', 'id');
    }

    
}
