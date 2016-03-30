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

	protected $m;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($m)
    {
	$this->m = $m;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	$m = $this->m;
	$command = $m->command;
        if($command == "createInstance")
	{
	        $instance = instance::find($m->instanceId);
		$instance->inuse = 1;
		$instance->currentSize = $m->currentSize;
		$instance->ipAddr = $m->ipAddr;
		$instance->port = $m->port;
		$instance->save();
	}
	if($command == "deleteInstance")
	{
		$i = instance::find($m->instanceId);
                if($i->instanceUsers())
                        $i->instanceUsers()->delete();
                $i->delete()
	}
    }
}
