<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\LearningPathwayAssignment;
use App\Models\UserLearningPathway;
use App\Models\Stripe\SubscribeCourse;
use App\Helpers\CustomHelper;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use App\Models\ChapterStudent;
use App\Models\courseAssignment;
use App\Models\AssignmentQuestion;
use App\Models\TestQuestionOption;

class AssesmentTestAnsFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-assesment-test-ans-fix';

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
            
            $data = AssignmentQuestion::query()
                                ->orderBy('id', 'Desc')
                                //->where('id', '3161')
                                ->where('assessment_account_id','4087')
                                ->get();
            if($data) {
                foreach($data as $row) {
                    if($row->is_correct == 1) {
                        $question_id = $row->question_id;
                        $test_option_right = TestQuestionOption::query()
                                        ->where('question_id',$question_id)
                                        ->where('is_right','1')
                                        ->first();
                        if($test_option_right) {
                            $row->update(
                                [
                                    'answer' => $test_option_right->id,
                                ]
                            );
                        }
                        
                    } else {
                        $question_id = $row->question_id;
                        $test_option_right = TestQuestionOption::query()
                                        ->where('question_id',$question_id)
                                        ->where('is_right','0')
                                        ->first();
                        if($test_option_right) {
                            $row->update(
                                [
                                    'answer' => $test_option_right->id,
                                ]
                            );
                        }
                    }
                }
            } 

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
