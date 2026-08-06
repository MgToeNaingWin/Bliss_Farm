<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Message $message
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->chat_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.new';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'chat_id' => $this->message->chat_id,
                'sender_id' => $this->message->sender_id,
                'type' => $this->message->type,
                'content' => $this->message->content,
                'metadata' => $this->message->metadata,
                'parent_message_id' => $this->message->parent_message_id,
                'is_edited' => $this->message->is_edited,
                'is_deleted' => $this->message->is_deleted,
                'created_at' => $this->message->created_at,
                'sender' => [
                    'id' => $this->message->sender->id,
                    'name' => $this->message->sender->name,
                    'profile_photo' => $this->message->sender->profile_photo,
                ],
                'parent_message' => $this->message->parentMessage ? [
                    'id' => $this->message->parentMessage->id,
                    'content' => $this->message->parentMessage->content,
                    'sender_name' => $this->message->parentMessage->sender->name,
                ] : null,
            ],
        ];
    }
}
