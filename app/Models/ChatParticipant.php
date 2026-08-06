<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatParticipant extends Model
{
    protected $fillable = [
        'chat_id',
        'user_id',
        'role',
        'last_read_message_id',
        'is_muted',
        'is_pinned',
        'joined_at',
    ];

    protected $casts = [
        'is_muted' => 'boolean',
        'is_pinned' => 'boolean',
        'joined_at' => 'datetime',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lastReadMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'last_read_message_id');
    }
}
