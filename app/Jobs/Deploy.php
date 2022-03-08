<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

// We have an intefrace ShouldBeUnique to make sure each job is unique to the class
// We have ShouldBeUniqueUntilProcessing to be unique until it starts processing
class Deploy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        // Redis has more flexibility, but you have to install it on your server
        // Funnel is used to limit the amount of keys
//        Redis::funnel('deployments')
//            ->limit(5)
//            ->block(10)
//            ->then(function (){
//                info("Start Deploying");
//                sleep(5);
//                info("Finish Deploying");
//            });

        // A laravel implementation for throtteling
//        Redis::throttle('deployments')
//            ->allow(10)
//            ->every(60)
//            ->block(10)
//            ->then(function (){
//                info("Start Deploying");
//                sleep(5);
//                info("Finish Deploying");
//            });

//        Cache::lock('deployments')->block(10,function(){
//            info("Start Deploying");
//            sleep(5);
//            info("Finish Deploying");
//        });


        //Middleware
        info("Start Deploying");
        sleep(5);
        info("Finish Deploying");
    }

//    public function uniqueFor()
//    {
//        // If it is unique the lock won't be returned until it is completed.
//        // So if something goes wrong no new jobs can be added to the queue
//        // So we add a timer to release to fix this problem
//        return 60;
//    }
//
//    public function uniqueId()
//    {
//        // Returns the unique id usually the class gets used
//        return 'deployments';
//    }

    public function middleware(){
        return [
//            new WithoutOverlapping('deployments',10)
        // Stops creating new jobs when there are to many exceptions
            // For example if a third party service is down
            new ThrottlesExceptions(10)
        ];
    }
}
