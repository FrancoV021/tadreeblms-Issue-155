<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\LearningPathwayAssignment;
use App\Models\LearningPathwayCourse;
use App\Models\courseAssignment;

class UpdateCourseAssignmentAssignDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-course-assessment-assigndate';

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
            
            $lpa = LearningPathwayAssignment::with('assignedBy', 'pathway')
                                            //->where('id','15')
                                            //->latest()
                                            ->get();
            if($lpa) {
                foreach($lpa as $row) {
                    $assgn_date = null;
                    $due_date = null;
                    $pathway_id = null;
                    $courses_ids = null;
                    $assign_to_users = !empty($row->assigned_to) ? json_decode($row->assigned_to) : [];
                    
                        foreach($assign_to_users as $user) {

                            if(1) { // in_array('4596',$assign_to_users)
                                $assgn_date = $row->created_at;
                                $due_date = $row->due_date;
                                $pathway_id = $row->pathway_id;
                                if($pathway_id) {
                                    $lpc = LearningPathwayCourse::query()
                                        ->where('pathway_id', $pathway_id)
                                        ->get();
                                    if($lpc) {

                                        foreach($lpc as $crow) {
                                            $courses_ids[] = $crow->course_id;
                                            $assign_user_string = implode(',', $assign_to_users);
                                            // update courseAssignment assign date
                                            if(1) { //$crow->course_id == 178
                                                //dd($assign_user_string);
                                                $csu = courseAssignment::query()
                                                        ->where('course_id', $crow->course_id)
                                                        //->where('assign_to',$assign_user_string)
                                                        ->whereRaw("FIND_IN_SET(?, assign_to) > 0", [$user])
                                                        ->first();
                                                if($csu) {
                                                    //dd("inside", $csu);
                                                    $csu->update(
                                                        [
                                                            'assign_date' =>  $assgn_date,
                                                            'due_date' => $due_date
                                                        ]
                                                    );
                                                } else {
                                                    //dd("outside");
                                                    courseAssignment::insert(
                                                        [
                                                            'title' => 'System Data Fix',
                                                            'assign_to' => $user,
                                                            'course_id' => $crow->course_id,
                                                            'assign_by' => 1,
                                                            'assign_date' =>  $assgn_date,
                                                            'due_date' => $due_date,
                                                            'is_pathway' => 1
                                                        ]
                                                    );
                                                }
                                            }
                                            
                                        }
                                    }

                                    

                                }
                            }
                        
                    }
                    
                    //dd($assgn_date->format('Y-m-d'), $due_date, $pathway_id, $courses_ids, $row->id);
                }
            }

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
