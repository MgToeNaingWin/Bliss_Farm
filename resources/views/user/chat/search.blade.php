@extends('user.layouts.master')

@section('bdy')
<div class="max-w-4xl mx-auto px-4">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('chat.index') }}" class="text-emerald-600 hover:text-emerald-800">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-xl font-bold text-emerald-950 font-[Bricolage_Grotesque]">ရှာဖွေရန်</h1>
    </div>

    {{-- Search Input --}}
    <div class="mb-6">
        <form action="{{ route('chat.search') }}" method="GET" class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-stone-400"></i>
            <input type="text" name="q" value="{{ request('q') }}" autofocus
                   placeholder="မက်ဆေ့များ၊ ဆက်သွယ်ရန်များ ရှာဖွေရန်..."
                   class="w-full pl-10 pr-4 py-3 bg-white rounded-2xl border border-stone-200 focus:border-emerald-400 focus:outline-none text-sm">
        </form>
    </div>

    @if(request('q'))
        {{-- Messages Results --}}
        @if(isset($messages) && $messages->count() > 0)
            <div class="mb-6">
                <h2 class="text-sm font-semibold text-stone-400 uppercase tracking-wider mb-3 px-1">
                    မက်ဆေ့များ ({{ $messages->count() }})
                </h2>
                <div class="space-y-2">
                    @foreach($messages as $msg)
                        <a href="{{ route('chat.show', $msg->chat_id) }}"
                           class="block p-3 bg-white rounded-2xl border border-stone-100 hover:border-emerald-200 transition">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-semibold text-emerald-600">{{ $msg->sender->name }}</span>
                                <span class="text-xs text-stone-300">•</span>
                                <span class="text-xs text-stone-400">{{ $msg->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-emerald-950">{{ Str::limit($msg->content, 100) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Contacts Results --}}
        @if(isset($contacts) && $contacts->count() > 0)
            <div>
                <h2 class="text-sm font-semibold text-stone-400 uppercase tracking-wider mb-3 px-1">
                    ဆက်သွယ်ရန်များ ({{ $contacts->count() }})
                </h2>
                <div class="space-y-2">
                    @foreach($contacts as $contact)
                        <a href="javascript:void(0)" onclick="startChat({{ $contact->id }})"
                           class="flex items-center gap-3 p-3 bg-white rounded-2xl border border-stone-100 hover:border-emerald-200 transition">
                            <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-amber-700 font-bold text-sm">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-emerald-950">{{ $contact->name }}</p>
                                <p class="text-xs text-stone-400">{{ $contact->email }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if((!isset($messages) || $messages->count() === 0) && (!isset($contacts) || $contacts->count() === 0))
            <div class="text-center py-12">
                <i class="fa-solid fa-magnifying-glass text-stone-300 text-4xl mb-3"></i>
                <p class="text-stone-400 text-sm">"{{ request('q') }}" အတွက် ရလဒ်မရှိပါ</p>
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <i class="fa-solid fa-magnifying-glass text-stone-300 text-4xl mb-3"></i>
            <p class="text-stone-400 text-sm">အကြောင်းအရာထည့်ပြီး ရှာဖွေပါ</p>
        </div>
    @endif
</div>

<script>
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
        window.location.href = data.redirect || ('{{ url("/chat") }}/' + (data.chat?.id || data.chat_id));
    });
}
</script>
@endsection
