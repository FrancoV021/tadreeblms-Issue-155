<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\LearningPathwayAssignment;
use App\Models\LearningPathwayCourse;
use App\Models\courseAssignment;
use DB;
use App\Models\Auth\User;

class RemoveDuplicateInternalUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove-duplicate-users-internal';

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
            
            $lpa = DB::select("SELECT email, emp_id, employee_type , 'active', COUNT(*) 
            FROM users 
            where employee_type='internal' 
            GROUP BY email, emp_id, employee_type, 'active'
            HAVING COUNT(*) > 1
            ");
            if($lpa) {
                foreach($lpa as $row) {
                    if($row->email) {
                        $duplicateUsers = User::where('email', $row->email)
                            ->where('emp_id', $row->emp_id)
                            ->where('employee_type', $row->employee_type)
                            ->get();
                        $firstUser = $duplicateUsers->first();
                        $duplicateUsers->shift();
                        foreach ($duplicateUsers as $user) {
                            $user->delete();
                        }
                    }
                    
                }
            }

        } catch (\Exception $e) {
            \Log::info('backup update failed - ' . $e->getMessage());
        }

        
    }
}
