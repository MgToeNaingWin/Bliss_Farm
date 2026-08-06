@props(['message'])

@php
    $isMine = $message->sender_id === auth()->id();
    $sender = $message->sender;
@endphp

<div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }} group"
     id="message-{{ $message->id }}"
     x-data="{ showActions: false, showReactions: false }">

    <div class="max-w-[75%] relative">
        {{-- Sender name (group chats) --}}
        @if(!$isMine && isset($chat) && $chat->type === 'group')
            <p class="text-xs text-stone-400 mb-0.5 ml-1 font-semibold">{{ $sender->name }}</p>
        @endif

        {{-- Reply preview --}}
        @if($message->parentMessage)
            <div class="bg-white/50 rounded-t-2xl px-3 py-1.5 border-l-3 border-emerald-400 mb-0.5 {{ $isMine ? 'rounded-br-none' : 'rounded-bl-none' }}">
                <p class="text-[10px] font-semibold text-emerald-600">{{ $message->parentMessage->sender->name }}</p>
                <p class="text-[10px] text-stone-400 truncate">{{ Str::limit($message->parentMessage->content, 50) }}</p>
            </div>
        @endif

        {{-- Message Bubble --}}
        <div class="rounded-2xl px-4 py-2.5 relative
            {{ $isMine
                ? 'bg-emerald-500 text-white rounded-br-md'
                : 'bg-white border border-stone-100 text-emerald-950 rounded-bl-md shadow-sm' }}"
            @dblclick="showReactions = !showReactions">

            {{-- Deleted message --}}
            @if($message->is_deleted)
                <p class="text-xs italic {{ $isMine ? 'text-emerald-100' : 'text-stone-400' }}">
                    <i class="fa-solid fa-ban mr-1"></i>ဖျက်လိုက်ပြီ
                </p>
            @else
                {{-- Content --}}
                @if($message->type === 'text')
                    <p class="text-sm whitespace-pre-wrap break-words">{{ $message->content }}</p>
                @elseif($message->type === 'image')
                    <img src="{{ asset('storage/' . $message->content) }}"
                         class="rounded-xl max-w-full cursor-pointer hover:opacity-90 transition"
                         onclick="window.open(this.src)">
                @elseif($message->type === 'video')
                    <video src="{{ asset('storage/' . $message->content) }}"
                           controls class="rounded-xl max-w-full"></video>
                @elseif($message->type === 'audio')
                    <audio src="{{ asset('storage/' . $message->content) }}" controls class="w-full"></audio>
                @elseif($message->type === 'file')
                    <a href="{{ asset('storage/' . $message->content) }}" target="_blank"
                       class="flex items-center gap-2 {{ $isMine ? 'text-white' : 'text-emerald-600' }}">
                        <i class="fa-solid fa-file-pdf text-lg"></i>
                        <span class="text-xs">{{ $message->metadata['original_name'] ?? 'ဖိုင်' }}</span>
                    </a>
                @endif

                {{-- Time & Read receipts --}}
                <div class="flex items-center justify-end gap-1 mt-1">
                    @if($message->is_edited)
                        <span class="text-[10px] {{ $isMine ? 'text-emerald-100' : 'text-stone-400' }}">ပြင်ပြီး</span>
                    @endif
                    <span class="text-[10px] {{ $isMine ? 'text-emerald-100' : 'text-stone-400' }}">
                        {{ $message->created_at->format('g:i A') }}
                    </span>
                    @if($isMine)
                        @php
                            $readStatus = $message->statuses->firstWhere('status', 'read');
                            $deliveredStatus = $message->statuses->firstWhere('status', 'delivered');
                        @endphp
                        @if($readStatus)
                            <i class="fa-solid fa-check-double text-emerald-100 text-[10px]"></i>
                        @elseif($deliveredStatus)
                            <i class="fa-solid fa-check-double text-emerald-200 text-[10px]"></i>
                        @else
                            <i class="fa-solid fa-check text-emerald-200 text-[10px]"></i>
                        @endif
                    @endif
                </div>
            @endif
        </div>

        {{-- Reactions --}}
        @if($message->reactions->count() > 0)
            <div class="flex gap-1 mt-1 {{ $isMine ? 'justify-end' : 'justify-start' }}">
                @foreach($message->reactions->groupBy('emoji') as $emoji => $reactions)
                    <button onclick="toggleReaction({{ $message->id }}, '{{ $emoji }}')"
                            class="bg-white border border-stone-100 rounded-full px-2 py-0.5 text-xs shadow-sm hover:shadow transition
                                   {{ $reactions->contains('user_id', auth()->id()) ? 'border-emerald-300 bg-emerald-50' : '' }}">
                        {{ $emoji }} <span class="text-stone-400">{{ $reactions->count() }}</span>
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Reaction Picker --}}
        <div x-show="showReactions" @click.outside="showReactions = false"
             x-transition class="absolute {{ $isMine ? 'right-0' : 'left-0' }} bottom-full mb-2 bg-white rounded-full shadow-xl border border-stone-100 px-2 py-1 flex gap-1 z-30">
            @foreach(['👍', '❤️', '😂', '😮', '😢', '🙏'] as $emoji)
                <button onclick="toggleReaction({{ $message->id }}, '{{ $emoji }}')"
                        class="w-8 h-8 rounded-full hover:bg-stone-100 flex items-center justify-center text-lg transition hover:scale-125">
                    {{ $emoji }}
                </button>
            @endforeach
        </div>

        {{-- Context Menu --}}
        <div x-show="showActions" @click.outside="showActions = false"
             x-transition class="absolute {{ $isMine ? 'right-0' : 'left-0' }} top-full mt-1 bg-white rounded-xl shadow-xl border border-stone-100 py-2 w-44 z-30">
            <button onclick="replyToMessage({{ $message->id }}, '{{ addslashes($sender->name) }}', '{{ addslashes(Str::limit($message->content, 50)) }}')"
                    class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2">
                <i class="fa-solid fa-reply text-stone-400"></i>ပြန်ဖြေရန်
            </button>
            <button onclick="forwardMessage({{ $message->id }})"
                    class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2">
                <i class="fa-solid fa-share text-stone-400"></i>ပို့ရန်
            </button>
            <button onclick="copyMessage('{{ addslashes($message->content) }}')"
                    class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2">
                <i class="fa-solid fa-copy text-stone-400"></i>ကူးယူရန်
            </button>
            @if($isMine && $message->type === 'text' && !$message->is_deleted)
                <button onclick="editMessage({{ $message->id }}, '{{ addslashes($message->content) }}')"
                        class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2">
                    <i class="fa-solid fa-pen text-stone-400"></i>ပြင်ဆင်ရန်
                </button>
                <button onclick="deleteMessage({{ $message->id }})"
                        class="w-full text-left px-4 py-2 text-sm hover:bg-red-50 text-red-500 flex items-center gap-2">
                    <i class="fa-solid fa-trash"></i>ဖျက်ရန်
                </button>
            @endif
        </div>
    </div>
</div>
