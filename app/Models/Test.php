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
class Test extends Model
{
    use SoftDeletes;

    protected $fillable = ['temp_id','title', 'description','slug','passing_score', 'published', 'course_id', 'lesson_id'];


    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        if(auth()->check()) {
            if (auth()->user()->hasRole('teacher')) {
                static::addGlobalScope('filter', function (Builder $builder) {
                    $builder->whereHas('course', function ($q) {
                        $q->whereHas('teachers', function ($t) {
                            $t->where('course_user.user_id', '=', auth()->user()->id);
                        });
                    });
                });
            }
        }

    }


    /**
     * Set to null if empty
     * @param $input
     */
    public function setCourseIdAttribute($input)
    {
        $this->attributes['course_id'] = $input ? $input : null;
    }


    /**
     * Set to null if empty
     * @param $input
     */
    public function setLessonIdAttribute($input)
    {
        $this->attributes['lesson_id'] = $input ? $input : null;
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withTrashed();
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id')->withTrashed();
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_test')->withTrashed();
    }

    public function test_questions()
    {
        return $this->hasMany(TestQuestion::class, 'test_id')->where('is_deleted',0);
    }


    public function test_active_questions($is_completed = 0, $completed_at = null)
    {
        return $this->hasMany(TestQuestion::class, 'test_id')
            ->when($is_completed, function ($q) use($completed_at) {
                if($completed_at) {
                    $q->where('created_at', '<', $completed_at);
                }
            })
            ->where('is_deleted',0)
            ->get();
    }


    public function chapterStudents()
    {
        return $this->morphMany(ChapterStudent::class,'model');
    }

    public function courseTimeline()
    {
        return $this->morphOne(CourseTimeline::class,'model');
    }

    public function isCompleted(){
        $isCompleted = $this->chapterStudents()->where('user_id', \Auth::id())->count();
        if($isCompleted > 0){
            return true;
        }
        return false;

    }


}
