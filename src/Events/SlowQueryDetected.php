<?php

namespace IvanoMatteo\LaravelSlowQuery\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SlowQueryDetected
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $report;
    public $queryExecuted;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->report = $info['report'];
        $this->queryExecuted = $info['queryExecuted'];
    }

}
