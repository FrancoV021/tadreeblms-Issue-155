<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class ManualAssessment extends Model
{
    protected $fillable = ['assessment_id', 'user_id', 'due_date', 'qualifying_percent'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assessment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAssignmentScorePercentageAttribute()
    {
        $assignment = $this->assignment;

        $correct_ans_count = $assignment->assignmentQuestions->where('is_correct', 1)->count();
        $total_ans_count = $assignment->assignmentQuestions->count();

        if (!$total_ans_count) {
            return 0;
        }

        return ($correct_ans_count / $total_ans_count) * 100;
    }

    public function getAssignmentScoreAttribute()
    {
        $assignment = $this->assignment;

        $marks_secured = $assignment->assignmentQuestions->where('is_correct', 1)->sum('marks');
        $total_marks = $assignment->assignmentQuestions->sum('marks');


        return $marks_secured . '/' . $total_marks;
    }

    public function scopeMine($q)
    {
        return $q->where('user_id', auth()->id());
    }


    public function getQualifyStatusAttribute()
    {
        return $this->assignment_score_percentage >= $this->qualifying_percent ? 'Passed' : 'Failed';
    }
}
