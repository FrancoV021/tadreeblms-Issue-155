<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class LearningPathwayAssignment extends Model
{
    protected $fillable = ['title', 'pathway_id', 'assigned_by', 'assigned_to', 'due_date'];

    public function pathway()
    {
        return $this->belongsTo(LearningPathway::class, 'pathway_id');
    }

    public function pathwayCourses()
    {
        return $this->hasMany(LearningPathwayCourse::class, 'pathway_id','pathway_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function getAssignedUserNamesAttribute()
    {
        $users = User::whereIn('id', json_decode($this->assigned_to))->get()->pluck('full_name')->toArray();
        return implode(', ', $users);
    }

    public function getAssignedUserEmailsAttribute()
    {
        $users = User::whereIn('id', json_decode($this->assigned_to))->get()->pluck('email')->toArray();
        return implode(', ', $users);
    }
}
