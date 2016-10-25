<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\DashboardBlockUpdated;

class UpdateDashboardBlock implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $block;

    public function __construct($block)
    {
        $this->block = $block;
    }

    public function handle()
    {
        event(new DashboardBlockUpdated($this->block));
    }
}
