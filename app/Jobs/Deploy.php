<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

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
        // Funnel is used to limit the amout of keys
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

    public function middleware(){
        return [
            new WithoutOverlapping('deployments',10)
        ];
    }
}
