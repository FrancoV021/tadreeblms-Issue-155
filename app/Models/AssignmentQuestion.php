<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class   AssignmentQuestion extends Model
{
    protected  $guarded = [];
    protected $table = 'assignment_questions';

    public $timestamps = false;
    public function options()
    {
        return $this->hasMany(TestQuestionOption::class, 'question_id', 'question_id');
    }

    public function test_questions()
    {
        return $this->hasMany(TestQuestion::class, 'id', 'question_id')->where('is_deleted', 0);
    }

    public function getAnswerTextAttribute()
    {
        $answer = '';
        if (str_contains($this->answer, '[')) {
            $tqos =  TestQuestionOption::whereIn('id', json_decode($this->answer))->orderBy('id', 'desc')->get();
            foreach ($tqos as $tqo) {
                $answer .= @$tqo->option_text . '</br>';
            }
        } elseif (ctype_digit($this->answer)) {
            $tqo =  TestQuestionOption::where('id', $this->answer)->orderBy('id', 'desc')->first();
            $answer = @$tqo->option_text;
        } else {
            $answer =  $this->answer;
        }

        return $answer;
    }

    public function getIsAnswerCorrectAttribute()
    {
        return $this->is_correct === 1 ? 1 : 0;
    }
}
