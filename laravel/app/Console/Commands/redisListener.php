<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class redisListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to Redis Channel \'demeterMiddle\' for queue';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Redis::subscribe('demeterMiddle', function($message) {
        	$m = json_decode($message);
	        dispatch( new App\Jobs\handleVmRequest, $m);

        });
    }


}
