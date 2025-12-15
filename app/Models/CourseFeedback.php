<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

/**
 * Class CourseFeedback
 *
 * @package App
 * @property text $question
 * @property string $question_image
 * @property integer $score
 */
class CourseFeedback extends Model
{
    protected $table = 'courses_feedbacks';
    protected $fillable = ['course_id', 'feedback_question_id', 'created_by'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */

    public function feedback()
    {
        return $this->belongsTo(FeedbackQuestion::class, 'feedback_question_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    // public function tests()
    // {
    //     return $this->belongsToMany(Test::class, 'question_test');
    // }
}
