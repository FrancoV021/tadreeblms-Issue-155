<?php


namespace App\Helpers;

use App\Http\Controllers\LessonsController;
use App\Models\Auth\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\courseAssignment;
use App\Models\AssignmentQuestion;
use App\Models\{Lesson, AttendanceStudent, ChapterStudent, StudentCourseFeedback, Certificate, UserCourseDetail};
use App\Models\Stripe\SubscribeCourse;
use Auth;
use DB;
use Carbon\Carbon;

class CustomValidation
{
    public static function checkIfCourseIsAlreadyAssigned($users = [], $course_ids_arr = [])
    { 
        $already_course_assigned = [
            'status' => false,
            'message' => null
        ];
        foreach($course_ids_arr as $course_id) {
            foreach($users as $user) {
                $course_already_assigned = courseAssignment::query()
                                    ->whereRaw("FIND_IN_SET(?, assign_to)", [$user])
                                    ->where('course_id', $course_id)
                                    ->count();
                if($course_already_assigned) {
                    $user_name = CustomHelper::getUserName($user);
                    $course_name = CustomHelper::getCourseName($course_id);
                    $already_course_assigned['status'] = true;
                    $already_course_assigned['message'] = sprintf("This %s is already assigned to this %s",$course_name,$user_name);
                    return $already_course_assigned;
                }                    
               
            }
        }

        return $already_course_assigned;
        
    }

}
