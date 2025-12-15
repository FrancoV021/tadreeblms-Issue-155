<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mtownsend\ReadTime\ReadTime;

/**
 * Class Test
 *
 * @package App
 * @property string $course
 * @property string $lesson
 * @property string $title
 * @property text $description
 * @property tinyInteger $published
 */
class TestQuestion extends Model
{
    use SoftDeletes;
    
    protected $table = 'test_questions';

    public function getUserAnswer($userId)
    {
        //dd($userId);
        $aq = AssignmentQuestion::where('question_id', $this->id)
        ->where('assessment_account_id', $userId)
        ->where('attempt', 2)
        ->orderBy('id', 'desc')
        ->first();

        

        if (!$aq) {
            $aq = AssignmentQuestion::where('question_id', $this->id)->where('assessment_account_id', $userId)
            ->where('attempt', 1)
            ->orderBy('id', 'desc')
            ->first(); 

            //dd( $aq );
        }
        
        if (!@$aq['answer']) {
            return null;
        }


        //dd($aq['answer']);

        $answer = '';

        if (str_contains($aq['answer'], '[')) {
            $tqos =  TestQuestionOption::whereIn('id', json_decode($aq['answer']))->orderBy('id', 'desc')->get();
            foreach ($tqos as $tqo) {
                $answer .= @$tqo->option_text . '</br>';
            }
        } elseif (ctype_digit($aq['answer'])) {

            $tqo =  TestQuestionOption::where('id', $aq['answer'])
                //->where('is_right', '1')
                ->orderBy('id', 'desc')
                ->first();
            $answer = @$tqo->option_text;

            //dd($answer, $aq['question_id'], $aq['answer']);

        } else {
            $answer =  $aq['answer'];
        }

        return [
            'answer' => $answer,
            'is_correct' => $aq->is_correct === 1 ? 1 : 0,
        ];
    }

    public function getCorrectAnswer($question_id)
    {
        //dd($question_id, $this->id);
        $tqo =  TestQuestionOption::where('question_id', $question_id)
                ->where('is_right', '1')
                ->orderBy('id', 'desc')
                ->first();
        $answer = @$tqo->option_text; 
        return $answer;
    }

    public function getTestSolutionsAttribute()
    {
        $tqo = TestQuestionOption::where('question_id', $this->id)->where('is_right', 1)->pluck('option_text')->toArray();
        return implode('</br>', $tqo);
    }
}
