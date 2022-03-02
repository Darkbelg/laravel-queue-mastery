<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Property on how long it takes before the job fails
    // public $timeout = 1;

    // How many times to try
    // -1 for infinite
    public $tries = 10;

    // Retry after these amount of seconds
    // exponential backoff so the bigger it gets the longer it waits this uses an array
//    public $backoff = [2,10 ,20];

    // The amount of times the que can trhow a exception before failing.
    public  $maxException = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        throw new \Exception('Failed!');

        return $this->release();
    }

//    public function retryUntil(){
//        return now()->addMinute();
//    }

    public function failed($e){
        info('Failed!!!');
    }
}
