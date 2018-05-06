<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\RssRepositoryContract;

class AutoUpdateRss implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $rssRC;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(RssRepositoryContract $rssRC)
    {
        $this->rssRC = $rssRC;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $xpaths = $this->rssRC->query();

        $this->rssRC->update($xpaths);
    }
}
