<?php

namespace App\Events;

use App\Models\report_post;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportPostWarn
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $report_post;
    public function __construct(report_post $report_post)
    {
        $this->report_post = $report_post;
    }
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
