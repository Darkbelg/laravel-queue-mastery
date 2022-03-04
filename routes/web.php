<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Bus\Batch;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // To execute a que
    // php artisan queue:work

    // Call the job directly:
    //(new \App\Jobs\SendWelcomeEmail())->handle();

    //Adding a delay:
    //\App\Jobs\SendWelcomeEmail::dispatch()->delay(5);

//    foreach (range(1,100) as $i){
//        \App\Jobs\SendWelcomeEmail::dispatch();
//    }

    // in order to retry a job
    // php artisan queue:retry UUID

    // Setup a special que
    // Run a special que and with priority
    // php artisan queue:work --queue=payments,default
//    \App\Jobs\ProcessPayment::dispatch()->onQueue('payments');

    // A chain is a series of task done sequentially
    // If one fails the whole job fails
//    $chain = [
//        new \App\Jobs\PullRepo(),
//        new \App\Jobs\RunTests(),
//        new \App\Jobs\Deploy(),
//    ];
//
//    \Illuminate\Support\Facades\Bus::chain($chain)->dispatch();

    // a batch is a series of jobs that can run parallel(Unless sleep command is influencing how it works this is not parallel
    // When a job inside a batch fails the entire job will be cancelled
    // Can be an array within an array
    $batch = [
        new \App\Jobs\PullRepo('ll1'),
        new \App\Jobs\PullRepo('ll2'),
        new \App\Jobs\PullRepo('ll3'),
    ];

//    \Illuminate\Support\Facades\Bus::Batch($batch)
//        ->allowFailures()
//        ->catch(function (Batch $batch,$e){
//            // Code to be executed when the batch fails
//        })
//        ->then(function(Batch $batch){
//            // Code to be executed when the batch succeeds
//        })
//        ->finally(function (Batch $batch){
//            // Code to be always executed
//        })
//        ->onQueue('deployments')
//        ->onConnection('database')
//        ->dispatch();

    \Illuminate\Support\Facades\Bus::chain([
        new \App\Jobs\Deploy(),
        function () {
        \Illuminate\Support\Facades\Bus::batch([
            new \App\Jobs\PullRepo('ll1'),
            new \App\Jobs\PullRepo('ll2'),
            new \App\Jobs\PullRepo('ll3'),
        ])->dispatch();
        }
    ])->dispatch();

    return view('welcome');
});
