<?php

namespace App\Events;

use App\Models\Complaint;
use App\Models\ComplaintStatusHistory;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ComplaintStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $complaint;
    public $history;

    public function __construct(Complaint $complaint, ComplaintStatusHistory $history)
    {
        $this->complaint = $complaint;
        $this->history = $history;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('complaint.' . $this->complaint->id);
    }

    public function broadcastWith()
    {
        return [
            'complaint_id' => $this->complaint->id,
            'complaint_number' => $this->complaint->complaint_number,
            'old_status' => $this->history->old_status,
            'new_status' => $this->history->new_status,
            'remarks' => $this->history->remarks,
            'changed_at' => $this->history->changed_at->toDateTimeString(),
            'changed_by' => $this->history->changed_by_name,
        ];
    }
}