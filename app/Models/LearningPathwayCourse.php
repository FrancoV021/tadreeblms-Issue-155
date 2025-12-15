<?php

namespace App\Models;

use App\Models\Stripe\SubscribeCourse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LearningPathwayCourse extends Model
{
    use SoftDeletes;
    protected $fillable = ['pathway_id', 'course_id', 'position'];

    public function course()
    {
        return $this->belongsTo(Course::class)->with('category');
    }

    public function pathway()
    {
        return $this->belongsTo(LearningPathway::class, 'pathway_id','id');
    }

    
    public function user_pathway()
    {
        return $this->belongsTo(UserLearningPathway::class, 'pathway_id','pathway_id');
    }

    public function learningPathwayAssignment()
    {
        return $this->hasMany(LearningPathwayAssignment::class,'pathway_id','pathway_id');
    }

    public function subscribedCourse()
    {
        return $this->hasOne(SubscribeCourse::class, 'course_id', 'course_id')
                    ->where('user_id', auth()->id());
    }
}
