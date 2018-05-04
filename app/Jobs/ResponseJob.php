<?php

namespace App\Jobs;

use Ably\Exceptions\AblyException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ResponseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $url;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     * @throws AblyException
     * @return void
     */
    public function handle()
    {
        \Log::info('publish to ably');
        \Ably::channel('fake:pulse:data')->publish('job_handled',['request_url'=>$this->url]);
    }
}
