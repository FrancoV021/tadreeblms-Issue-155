<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningPathway extends Model
{
    protected $fillable = ['title', 'description','in_sequence'];
    
    public function learningPathwayCoursesOrdered()
    {
        return $this->hasMany(LearningPathwayCourse::class, 'pathway_id')->orderBy('position');
    }

    public function learningPathwayUsers()
    {
        return $this->hasMany(UserLearningPathway::class, 'pathway_id');
    }
}
