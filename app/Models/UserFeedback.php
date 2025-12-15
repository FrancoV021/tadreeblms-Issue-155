<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

/**
 * Class CourseFeedback
 *
 * @package App
 * @property text $question
 * @property string $question_image
 * @property integer $score
 */
class UserFeedback extends Model
{
    protected $table = 'user_feedback';
    protected $fillable = ['course_id', 'user_id', 'feedback_id', 'feedback'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courseFeedback()
    {
        return $this->belongsTo(CourseFeedback::class, 'course_id', 'course_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function feedbackQuestion()
    {
        return $this->belongsTo(FeedbackQuestion::class, 'feedback_id', 'id');
    }

    public function getQuestionAnswersAttribute()
    {
        $trs = "";

        $ufs =  UserFeedback::where('course_id', $this->course_id)
                    ->where('user_id', $this->user_id)
                    ->orderBy('id','desc')
                    ->get()
                    ->unique('feedback_id')
                    ->values();

        //dd($ufs);

        foreach ($ufs as $uf) {

            if (in_array($uf->feedback_questions_type, [1, 2])) {
                if (str_contains($uf->feedback, '[')) {
                    $fo = FeedbackOption::whereIn('id', json_decode($uf->feedback))->pluck('option_text')->toArray();
                    $answer = implode(', ', $fo);
                } else {
                    $answer = FeedbackOption::firstWhere('id', json_decode($uf->feedback))->option_text??'';
                }
            } else {
                $answer = $uf->feedback;
            }

            $question = @$uf->feedbackQuestion->question;

            $trs .= "
            <tr>
                <td>$question</td>
                <td>$answer</td>
            </tr>
            ";
        }

        $html = "
        <table class='table'>
            <tr>
                <th>Question</th>
                <th>Answer</th>
            </tr>
            $trs
        </table>
        ";

        return $html;
    }
}
