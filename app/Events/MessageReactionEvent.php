<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageReactionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Message $message,
        public string $action, // 'added' | 'removed' | 'updated'
        public string $emoji
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->chat_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.reaction';
    }

    public function broadcastWith(): array
    {
        return [
            'message_id' => $this->message->id,
            'action' => $this->action,
            'emoji' => $this->emoji,
            'reactions' => $this->message->reactions->map(fn($r) => [
                'id' => $r->id,
                'emoji' => $r->emoji,
                'user_id' => $r->user_id,
                'user_name' => $r->user->name,
            ]),
        ];
    }
}
