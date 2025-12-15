<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

/**
 * Class FeedbackQuestion
 *
 * @package App
 * @property text $question
 * @property string $question_image
 * @property integer $score
 */
class FeedbackOption extends Model
{
    protected $fillable = ['question_id', 'option_text', 'is_right'];
    protected $table = "feedback_option";

    public $timestamps = false;
}
