@extends('user.layouts.master')

@section('bdy')
<div class="max-w-4xl mx-auto px-4">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('chat.index') }}" class="text-emerald-600 hover:text-emerald-800">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-xl font-bold text-emerald-950 font-[Bricolage_Grotesque]">စကားပြောမှုအသစ်</h1>
    </div>

    {{-- Search --}}
    <div class="mb-4">
        <input type="text" id="contact-search" oninput="filterContacts()"
               placeholder="ဆက်သွယ်ရန် ရှာဖွေရန်..."
               class="w-full px-4 py-3 bg-white rounded-2xl border border-stone-200 focus:border-emerald-400 focus:outline-none text-sm">
    </div>

    {{-- Create Group --}}
    <a href="{{ route('chat.storeGroup') }}"
       class="flex items-center gap-3 p-4 bg-white rounded-2xl border border-stone-100 hover:border-emerald-200 mb-4 transition">
        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
            <i class="fa-solid fa-users text-emerald-600"></i>
        </div>
        <div>
            <p class="font-semibold text-emerald-950 text-sm">အုပ်စုဖွဲ့ရန်</p>
            <p class="text-xs text-stone-400">လူ ၂ ဦးထက်မကဖြင့် စကားပြောရန်</p>
        </div>
    </a>

    {{-- Contacts --}}
    <div id="contacts-container" class="space-y-2">
        <p class="text-center text-stone-400 text-sm py-8">ခေါ်ယူနေပါသည်...</p>
    </div>
</div>

<script>
const contacts = [];
const CSRF = '{{ csrf_token() }}';

fetch('{{ route("chat.contacts") }}', { headers: { 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(data => {
        contacts.push(...data.contacts);
        renderContacts(contacts);
    });

function renderContacts(list) {
    const container = document.getElementById('contacts-container');
    if (list.length === 0) {
        container.innerHTML = '<p class="text-center text-stone-400 text-sm py-8">ဆက်သွယ်ရန်မရှိပါ</p>';
        return;
    }
    container.innerHTML = list.map(c => `
        <a href="javascript:void(0)" onclick="${c.existing_chat_id
            ? `window.location.href='{{ url("/chat") }}/${c.existing_chat_id}'`
            : `startChat(${c.id})`}"
           class="flex items-center gap-3 p-4 bg-white rounded-2xl border border-stone-100 hover:border-emerald-200 transition">
            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center shrink-0">
                <span class="text-amber-700 font-bold">${c.name.charAt(0).toUpperCase()}</span>
            </div>
            <div>
                <p class="font-semibold text-emerald-950 text-sm">${c.name}</p>
                <p class="text-xs text-stone-400">${c.email || ''}</p>
            </div>
        </a>
    `).join('');
}

function filterContacts() {
    const q = document.getElementById('contact-search').value.toLowerCase();
    const filtered = contacts.filter(c => c.name.toLowerCase().includes(q) || (c.email || '').toLowerCase().includes(q));
    renderContacts(filtered);
}

function startChat(userId) {
    fetch('{{ route("chat.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ user_id: userId })
    })
    .then(r => r.json())
    .then(data => {
        window.location.href = data.redirect || ('{{ url("/chat") }}/' + (data.chat?.id || data.chat_id));
    });
}
</script>
@endsection
