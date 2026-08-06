@extends('user.layouts.master')

@push('head')
<script>
    window.CHAT_ID = {{ $chat->id }};
    window.CURRENT_USER_ID = {{ auth()->id() }};
    window.CSRF_TOKEN = '{{ csrf_token() }}';
    window.PUSHER_KEY = '{{ config("services.pusher.key") }}';
    window.PUSHER_CLUSTER = '{{ config("services.pusher.cluster", "ap1") }}';
</script>
@endpush

@section('bdy')
<div class="max-w-4xl mx-auto flex flex-col h-[calc(100vh-8rem)]"
     x-data="chatApp()" x-init="init()" x-cloak>

    {{-- Header --}}
    <div class="shrink-0 bg-white border-b border-stone-100 px-4 py-3 flex items-center gap-3 rounded-t-2xl shadow-sm">
        <a href="{{ route('chat.index') }}" class="text-emerald-600 hover:text-emerald-800">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>

        @if($chat->type === 'individual' && $otherUser)
            <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center shrink-0">
                <span class="text-amber-700 font-bold">{{ strtoupper(substr($otherUser->name, 0, 1)) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="font-bold text-emerald-950 text-sm truncate">{{ $otherUser->name }}</h2>
                <p class="text-xs text-stone-400" id="status-text">
                    <span x-show="isOnline" class="text-emerald-500">Online</span>
                    <span x-show="!isOnline">Offline</span>
                </p>
            </div>
        @else
            <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                @if($chat->avatar)
                    <img src="{{ asset('storage/' . $chat->avatar) }}" class="w-full h-full rounded-full object-cover">
                @else
                    <i class="fa-solid fa-users text-emerald-600"></i>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="font-bold text-emerald-950 text-sm truncate">{{ $chat->name }}</h2>
                <p class="text-xs text-stone-400">{{ $chat->participants->count() }} ဦး</p>
            </div>
        @endif

        <div class="flex items-center gap-2">
            <a href="#" class="w-9 h-9 rounded-full hover:bg-stone-100 flex items-center justify-center text-stone-500 transition">
                <i class="fa-solid fa-phone text-sm"></i>
            </a>
            <a href="#" class="w-9 h-9 rounded-full hover:bg-stone-100 flex items-center justify-center text-stone-500 transition">
                <i class="fa-solid fa-video text-sm"></i>
            </a>
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="w-9 h-9 rounded-full hover:bg-stone-100 flex items-center justify-center text-stone-500 transition">
                    <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                </button>
                <div x-show="open" @click.outside="open = false"
                     x-transition class="absolute right-0 top-full mt-1 bg-white rounded-xl shadow-xl border border-stone-100 py-2 w-48 z-50">
                    <button onclick="toggleMute()" class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2">
                        <i class="fa-solid fa-bell-slash text-stone-400"></i>အသံပိတ်ရန်
                    </button>
                    <button onclick="togglePin()" class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2">
                        <i class="fa-solid fa-thumbtack text-stone-400"></i>Pin ထားရန်
                    </button>
                    <a href="{{ route('chat.show', $chat) }}" class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2">
                        <i class="fa-solid fa-image text-stone-400"></i>မီဒီယာ
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Messages --}}
    <div class="flex-1 overflow-y-auto px-4 py-4 space-y-3 bg-stone-50/50"
         id="messages-container"
         x-ref="messagesContainer"
         @scroll="handleScroll()">

        @if($messages->hasPages())
            <div class="text-center py-2">
                <button onclick="loadOlderMessages()" id="load-more-btn"
                        class="text-xs text-emerald-600 hover:text-emerald-800 font-semibold">
                    <i class="fa-solid fa-arrow-up mr-1"></i>ပိုမိုဖတ်ရန်
                </button>
            </div>
        @endif

        @foreach($messages as $message)
            @include('components.chat.message-bubble', ['message' => $message])
        @endforeach

        {{-- Typing Indicator --}}
        <div x-show="typingUsers && typingUsers.length > 0" x-transition class="flex items-center gap-2 px-2">
            <div class="bg-white rounded-2xl px-4 py-2 shadow-sm border border-stone-100">
                <div class="flex items-center gap-1">
                    <span class="text-xs text-stone-400" x-text="(typingUsers || []).map(u => u.name).join(', ') + ' ရေးနေသည်'"></span>
                    <div class="flex gap-0.5 ml-1">
                        <span class="w-1.5 h-1.5 bg-stone-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                        <span class="w-1.5 h-1.5 bg-stone-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                        <span class="w-1.5 h-1.5 bg-stone-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Input Bar --}}
    <div class="shrink-0 bg-white border-t border-stone-100 px-4 py-3 rounded-b-2xl shadow-sm">
        {{-- Reply Preview --}}
        <div x-show="replyTo" x-transition class="mb-2 p-2 bg-emerald-50 rounded-xl border-l-4 border-emerald-400 flex items-center justify-between">
            <div class="min-w-0">
                <p class="text-xs font-semibold text-emerald-700" x-text="replyTo?.sender_name"></p>
                <p class="text-xs text-stone-500 truncate" x-text="replyTo?.content"></p>
            </div>
            <button @click="replyTo = null" class="text-stone-400 hover:text-stone-600 shrink-0 ml-2">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Edit Preview --}}
        <div x-show="editingMessage" x-transition class="mb-2 p-2 bg-amber-50 rounded-xl border-l-4 border-amber-400 flex items-center justify-between">
            <div class="min-w-0">
                <p class="text-xs font-semibold text-amber-700">ပြင်ဆင်နေသည်</p>
                <p class="text-xs text-stone-500 truncate" x-text="editingMessage?.content"></p>
            </div>
            <button @click="editingMessage = null" class="text-stone-400 hover:text-stone-600 shrink-0 ml-2">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="flex items-end gap-2">
            {{-- Attachment Button --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="w-10 h-10 rounded-full hover:bg-stone-100 flex items-center justify-center text-stone-500 transition shrink-0">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <div x-show="open" @click.outside="open = false"
                     x-transition class="absolute bottom-full left-0 mb-2 bg-white rounded-xl shadow-xl border border-stone-100 py-2 w-44 z-50">
                    <label class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-image text-emerald-500"></i>ဓာတ်ပုံ
                        <input type="file" accept="image/*" class="hidden" onchange="sendFile(this, 'image')">
                    </label>
                    <label class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-video text-blue-500"></i>ဗီဒီယို
                        <input type="file" accept="video/*" class="hidden" onchange="sendFile(this, 'video')">
                    </label>
                    <label class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-file text-amber-500"></i>ဖိုင်
                        <input type="file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="hidden" onchange="sendFile(this, 'file')">
                    </label>
                    <label class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-microphone text-red-500"></i>အသံ
                        <input type="file" accept="audio/*" class="hidden" onchange="sendFile(this, 'audio')">
                    </label>
                </div>
            </div>

            {{-- Text Input --}}
            <div class="flex-1 relative">
                <textarea id="message-input"
                          x-model="messageText"
                          @keydown.enter.prevent="sendMessage()"
                          @input="handleTyping()"
                          placeholder="မက်ဆေ့ရေးရန်..."
                          rows="1"
                          class="w-full resize-none border border-stone-200 rounded-2xl px-4 py-2.5 text-sm focus:border-emerald-400 focus:outline-none max-h-32"></textarea>
            </div>

            {{-- Send Button --}}
            <button @click="sendMessage()"
                    :disabled="!messageText.trim()"
                    class="w-10 h-10 rounded-full flex items-center justify-center transition shrink-0"
                    :class="messageText.trim() ? 'bg-emerald-500 hover:bg-emerald-600 text-white' : 'bg-stone-100 text-stone-400'">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
@endsection
