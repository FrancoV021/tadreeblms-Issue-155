<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLearningPathway extends Model
{
    protected $fillable = ['user_id', 'pathway_id', 'progress', 'started_at', 'completed_at'];

    public function learningPathway()
    {
        return $this->belongsTo(LearningPathway::class, 'pathway_id');
    }

    public function learningPathwayCoursesOrdered()
    {
        return $this->hasMany(LearningPathwayCourse::class, 'pathway_id', 'pathway_id')->with('subscribedCourse')->orderBy('position');
    }

}
