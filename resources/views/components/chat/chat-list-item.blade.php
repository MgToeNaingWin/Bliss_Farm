@props(['chat'])

@php
    $userId = auth()->id();
    $otherUser = $chat->other_user ?? $chat->getOtherParticipant($userId);
    $unread = $chat->unread_count ?? $chat->getUnreadCount($userId);
    $lastMsg = $chat->latestMessage;
    $participant = $chat->participants->firstWhere('id', $userId);
@endphp

<a href="{{ route('chat.show', $chat) }}"
   class="flex items-center gap-3 p-3 bg-white rounded-2xl border border-stone-100 hover:border-emerald-200 hover:shadow-sm transition group">
    {{-- Avatar --}}
    <div class="relative shrink-0">
        @if($chat->type === 'group')
            <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                @if($chat->avatar)
                    <img src="{{ asset('storage/' . $chat->avatar) }}" class="w-full h-full rounded-full object-cover">
                @else
                    <i class="fa-solid fa-users text-emerald-600"></i>
                @endif
            </div>
        @elseif($otherUser)
            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                @if($otherUser->profile_photo)
                    <img src="{{ asset('storage/' . $otherUser->profile_photo) }}" class="w-full h-full rounded-full object-cover">
                @else
                    <span class="text-amber-700 font-bold text-lg">{{ strtoupper(substr($otherUser->name, 0, 1)) }}</span>
                @endif
            </div>
        @endif

        {{-- Online indicator --}}
        @if($otherUser && $otherUser->onlineStatus?->is_online)
            <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-white"></div>
        @endif
    </div>

    {{-- Content --}}
    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between mb-0.5">
            <h3 class="font-semibold text-sm text-emerald-950 truncate group-hover:text-emerald-700 transition">
                {{ $chat->type === 'group' ? $chat->name : ($otherUser?->name ?? 'Unknown') }}
            </h3>
            @if($lastMsg)
                <span class="text-xs text-stone-400 shrink-0 ml-2">{{ $lastMsg->created_at->format('g:i A') }}</span>
            @endif
        </div>
        <div class="flex items-center justify-between">
            <p class="text-xs text-stone-400 truncate">
                @if($lastMsg)
                    @if($lastMsg->is_deleted)
                        <i class="fa-solid fa-ban text-stone-300 mr-1"></i>ဖျက်လိုက်ပြီ
                    @elseif($lastMsg->type === 'text')
                        {{ Str::limit($lastMsg->content, 40) }}
                    @elseif($lastMsg->type === 'image')
                        <i class="fa-solid fa-image text-stone-300 mr-1"></i>ဓာတ်ပုံ
                    @elseif($lastMsg->type === 'video')
                        <i class="fa-solid fa-video text-stone-300 mr-1"></i>ဗီဒီယို
                    @elseif($lastMsg->type === 'audio')
                        <i class="fa-solid fa-microphone text-stone-300 mr-1"></i>အသံ
                    @elseif($lastMsg->type === 'file')
                        <i class="fa-solid fa-file text-stone-300 mr-1"></i>ဖိုင်
                    @endif
                @else
                    <span class="text-stone-300">မက်ဆေ့မရှိသေးပါ</span>
                @endif
            </p>

            @if($unread > 0)
                <span class="bg-emerald-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center shrink-0 ml-2">
                    {{ $unread > 99 ? '99+' : $unread }}
                </span>
            @endif

            @if($participant?->is_muted)
                <i class="fa-solid fa-bell-slash text-stone-300 text-xs ml-1 shrink-0"></i>
            @endif

            @if($participant?->is_pinned)
                <i class="fa-solid fa-thumbtack text-amber-400 text-xs ml-1 shrink-0"></i>
            @endif
        </div>
    </div>
</a>
