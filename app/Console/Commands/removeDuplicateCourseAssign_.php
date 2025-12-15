<?php

namespace App\Console\Commands;

use App\Models\courseAssignment;
use App\Models\Auth\User;
use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class removeDuplicateCourseAssign_ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove-duplicate-course-assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
         
        try {
            $total_users_has_duplicate = [];
            $total_courses_has_duplicate = [];
            $total_courses_assesment_ids = [];
            $users = User::query()
                            ->where('id','4473')
                            ->get();
            foreach($users as $user) {
                $user_id = $user->id;
                $courses = Course::get();
                foreach($courses as $course) {
                    $course_id = $course->id;
                    $count = courseAssignment::query()
                                    ->whereRaw("FIND_IN_SET(?, assign_to)", [$user_id])
                                    ->where('course_id', $course_id)
                                    ->count();
                    if($count > 1) {
                        $total_users_has_duplicate[] = $user_id;
                        $total_courses_has_duplicate[] = $course_id;
                        //$total_courses_assesment_ids[] = $course_id;
                    }
                }
                
            }
            
            dd($total_users_has_duplicate, $total_courses_has_duplicate);

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
