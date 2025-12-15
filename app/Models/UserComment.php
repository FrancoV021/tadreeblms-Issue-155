<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Class UserComment
 *
 * @package App
 * @property text $question
 * @property string $question_image
 * @property integer $score
 */
class UserComment extends Model
{
    protected $fillable = ['course_id', 'comment', 'employee_id'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Auth\User');
    }
}
