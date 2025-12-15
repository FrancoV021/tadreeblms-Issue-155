<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessSubscribeCourseChunk;
use App\Models\Stripe\SubscribeCourse;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

class DispatchSubscribeCourseJobs extends Command
{
    protected $signature = 'subscribe:update';
    protected $description = 'Dispatch jobs to update SubscribeCourse records in chunks';

    public function handle()
    {
        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now();

        SubscribeCourse::whereHas('course')
            ->orderBy('id', 'desc')
            ->where('is_completed', '=' , 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->chunk(10, function ($chunk) {
                $ids = $chunk->pluck('id')->toArray();
                ProcessSubscribeCourseChunk::dispatch($ids)->onQueue('low');
            });
    }
}
