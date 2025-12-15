<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

/**
 * Class UserResponse
 *
 * @package App
 * @property text $question
 * @property string $question_image
 * @property integer $score
 */
class UserResponse extends Model
{
    protected $fillable = ['course_id', 'question_id', 'response', 'employee_id'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    public function feedbackQuestion()
    {
        return $this->belongsTo('App\Models\FeedbackQuestion');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }
    // public function tests()
    // {
    //     return $this->belongsToMany(Test::class, 'question_test');
    // }
}
