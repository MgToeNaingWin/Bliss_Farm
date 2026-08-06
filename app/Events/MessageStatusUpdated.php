<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Message $message,
        public string $status // 'read' | 'edited'
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->chat_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.status';
    }

    public function broadcastWith(): array
    {
        return [
            'message_id' => $this->message->id,
            'chat_id' => $this->message->chat_id,
            'status' => $this->status,
            'content' => $this->message->content,
            'is_edited' => $this->message->is_edited,
        ];
    }
}
