@extends('user.layouts.master')

@section('bdy')
<div class="max-w-4xl mx-auto px-4">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-emerald-950 font-[Bricolage_Grotesque]">
            <i class="fa-solid fa-comments text-amber-400 mr-2"></i>စကားပြောရန်
        </h1>
        <a href="{{ route('chat.search') }}" class="text-emerald-600 hover:text-emerald-800 text-sm">
            <i class="fa-solid fa-magnifying-glass mr-1"></i>ရှာဖွေရန်
        </a>
    </div>

    {{-- Search Bar --}}
    <div class="mb-4">
        <form action="{{ route('chat.search') }}" method="GET" class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 text-sm"></i>
            <input type="text" name="q" placeholder="စကားပြောမှုများ ရှာဖွေရန်..."
                   class="w-full pl-10 pr-4 py-3 bg-white rounded-2xl border border-stone-200 focus:border-emerald-400 focus:outline-none text-sm">
        </form>
    </div>

    {{-- Pinned Chats --}}
    @php
        $pinnedChats = $chats->filter(fn($chat) => $chat->pivot->is_pinned ?? false);
        $recentChats = $chats->filter(fn($chat) => !($chat->pivot->is_pinned ?? false));
    @endphp

    @if($pinnedChats->count() > 0)
        <div class="mb-4">
            <h2 class="text-xs font-semibold text-stone-400 uppercase tracking-wider mb-2 px-1">
                <i class="fa-solid fa-thumbtack text-amber-400 mr-1"></i>Pinထားသော စကားပြောမှုများ
            </h2>
            <div class="space-y-2">
                @foreach($pinnedChats as $chat)
                    @include('components.chat.chat-list-item', ['chat' => $chat])
                @endforeach
            </div>
        </div>
    @endif

    {{-- Recent Chats --}}
    <div class="mb-4">
        @if($pinnedChats->count() > 0)
            <h2 class="text-xs font-semibold text-stone-400 uppercase tracking-wider mb-2 px-1">
                <i class="fa-solid fa-clock text-stone-400 mr-1"></i>မကြာသေးမီ စကားပြောမှုများ
            </h2>
        @endif
        <div class="space-y-2">
            @forelse($recentChats as $chat)
                @include('components.chat.chat-list-item', ['chat' => $chat])
            @empty
                <div class="text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-4 bg-emerald-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-comments text-emerald-400 text-3xl"></i>
                    </div>
                    <p class="text-stone-500 text-sm mb-4">စကားပြောမှုမရှိသေးပါ</p>
                    <a href="javascript:void(0)" onclick="showNewChatModal()"
                       class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">
                        <i class="fa-solid fa-plus"></i>စကားပြောမှုအသစ်
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    {{-- FAB --}}
    <a href="javascript:void(0)" onclick="showNewChatModal()"
       class="fixed bottom-24 right-6 md:bottom-8 md:right-8 w-14 h-14 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full shadow-lg shadow-emerald-500/30 flex items-center justify-center transition hover:scale-110 z-40">
        <i class="fa-solid fa-plus text-xl"></i>
    </a>

    {{-- New Chat Modal --}}
    <div id="new-chat-modal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-end md:items-center justify-center">
        <div class="bg-white w-full md:w-96 md:rounded-2xl rounded-t-2xl max-h-[80vh] overflow-hidden">
            <div class="p-4 border-b border-stone-100 flex items-center justify-between">
                <h3 class="font-bold text-emerald-950">စကားပြောမှုအသစ်</h3>
                <button onclick="hideNewChatModal()" class="text-stone-400 hover:text-stone-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="p-4">
                <a href="{{ route('chat.storeGroup') }}"
                   class="flex items-center gap-3 p-3 hover:bg-emerald-50 rounded-xl transition mb-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-users text-emerald-600"></i>
                    </div>
                    <span class="text-sm font-semibold text-emerald-950">အုပ်စုဖွဲ့ရန်</span>
                </a>
                <div class="border-t border-stone-100 pt-3">
                    <p class="text-xs text-stone-400 mb-2">ဆက်သွယ်ရန်</p>
                    <div id="contacts-list" class="space-y-1 max-h-60 overflow-y-auto">
                        <p class="text-center text-stone-400 text-sm py-4">ခေါ်ယူနေပါသည်...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showNewChatModal() {
    document.getElementById('new-chat-modal').classList.remove('hidden');
    loadContacts();
}

function hideNewChatModal() {
    document.getElementById('new-chat-modal').classList.add('hidden');
}

function loadContacts() {
    fetch('{{ route("chat.contacts") }}', {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        const list = document.getElementById('contacts-list');
        if (data.contacts.length === 0) {
            list.innerHTML = '<p class="text-center text-stone-400 text-sm py-4">ဆက်သွယ်ရန်မရှိပါ</p>';
            return;
        }
        list.innerHTML = data.contacts.map(c => {
            const url = c.existing_chat_id
                ? '{{ url("/chat") }}/' + c.existing_chat_id
                : '#';
            const action = c.existing_chat_id
                ? `window.location.href='${url}'`
                : `startChat(${c.id})`;
            return `
                <a href="javascript:void(0)" onclick="${action}"
                   class="flex items-center gap-3 p-3 hover:bg-emerald-50 rounded-xl transition cursor-pointer">
                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center shrink-0">
                        <span class="text-amber-700 font-bold text-sm">${c.name.charAt(0).toUpperCase()}</span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-emerald-950">${c.name}</p>
                        <p class="text-xs text-stone-400">${c.email || ''}</p>
                    </div>
                </a>`;
        }).join('');
    });
}

function startChat(userId) {
    fetch('{{ route("chat.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ user_id: userId })
    })
    .then(r => r.json())
    .then(data => {
        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            window.location.href = '{{ url("/chat") }}/' + data.chat_id;
        }
    });
}
</script>
@endsection
