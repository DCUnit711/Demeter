<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\instance;
use Illuminate\Http\Request;


class handleVmRequest extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $r)
    {
	$command = $r->input("command");
        if($command == "createInstance")
	{
	        $instance = instance::find($r->input('instanceId'));
		$instance->inuse = 1;
		$instance->save();
	}
    }
}
