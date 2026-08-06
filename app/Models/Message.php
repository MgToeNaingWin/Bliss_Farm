<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'sender_id',
        'type',
        'content',
        'metadata',
        'parent_message_id',
        'is_edited',
        'is_deleted',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_edited' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function parentMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'parent_message_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Message::class, 'parent_message_id');
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(MessageStatus::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(MessageReaction::class);
    }

    public function isOwnedBy($userId): bool
    {
        return $this->sender_id === $userId;
    }

    public function getFormattedTimeAttribute(): string
    {
        return $this->created_at->format('g:i A');
    }
}
