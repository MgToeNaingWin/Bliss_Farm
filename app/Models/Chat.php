<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends Model
{
    protected $fillable = ['type', 'name', 'avatar', 'created_by'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_participants')
            ->withPivot(['role', 'is_muted', 'is_pinned', 'last_read_message_id', 'joined_at'])
            ->withTimestamps();
    }

    public function chatParticipants(): HasMany
    {
        return $this->hasMany(ChatParticipant::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function getOtherParticipant($userId)
    {
        if ($this->type !== 'individual') {
            return null;
        }

        return $this->participants()
            ->where('users.id', '!=', $userId)
            ->first();
    }

    public function getUnreadCount($userId): int
    {
        $participant = $this->chatParticipants()
            ->where('user_id', $userId)
            ->first();

        if (!$participant || !$participant->last_read_message_id) {
            return $this->messages()->where('sender_id', '!=', $userId)->count();
        }

        return $this->messages()
            ->where('id', '>', $participant->last_read_message_id)
            ->where('sender_id', '!=', $userId)
            ->count();
    }
}
