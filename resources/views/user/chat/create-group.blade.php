@extends('user.layouts.master')

@section('bdy')
<div class="max-w-4xl mx-auto px-4">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('chat.index') }}" class="text-emerald-600 hover:text-emerald-800">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-xl font-bold text-emerald-950 font-[Bricolage_Grotesque]">အုပ်စုဖွဲ့ရန်</h1>
    </div>

    <form action="{{ route('chat.storeGroup') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        {{-- Group Photo --}}
        <div class="flex justify-center">
            <label class="relative cursor-pointer">
                <div id="avatar-preview" class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center overflow-hidden border-4 border-white shadow-lg">
                    <i class="fa-solid fa-camera text-emerald-400 text-2xl" id="avatar-icon"></i>
                    <img id="avatar-img" class="w-full h-full object-cover hidden">
                </div>
                <input type="file" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
            </label>
        </div>

        {{-- Group Name --}}
        <div>
            <label class="block text-sm font-semibold text-emerald-950 mb-1">အုပ်စုအမည် *</label>
            <input type="text" name="name" required maxlength="255"
                   placeholder="အုပ်စုအမည်ထည့်ပါ..."
                   class="w-full px-4 py-3 bg-white rounded-2xl border border-stone-200 focus:border-emerald-400 focus:outline-none text-sm">
            @error('name')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Participants --}}
        <div>
            <label class="block text-sm font-semibold text-emerald-950 mb-2">ပါဝင်သူများ *</label>
            <div id="participants-list" class="space-y-2 max-h-60 overflow-y-auto">
                <p class="text-center text-stone-400 text-sm py-4">ခေါ်ယူနေပါသည်...</p>
            </div>
            @error('participants')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 rounded-2xl transition shadow-lg shadow-emerald-500/20">
            <i class="fa-solid fa-users mr-2"></i>အုပ်စုဖွဲ့ရန်
        </button>
    </form>
</div>

<script>
fetch('{{ route("chat.contacts") }}', { headers: { 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(data => {
        const list = document.getElementById('participants-list');
        if (data.contacts.length === 0) {
            list.innerHTML = '<p class="text-center text-stone-400 text-sm py-4">ပါဝင်နိုင်သူမရှိပါ</p>';
            return;
        }
        list.innerHTML = data.contacts.map(c => `
            <label class="flex items-center gap-3 p-3 bg-white rounded-2xl border border-stone-100 hover:border-emerald-200 cursor-pointer transition">
                <input type="checkbox" name="participants[]" value="${c.id}"
                       class="w-4 h-4 text-emerald-500 rounded border-stone-300 focus:ring-emerald-400">
                <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center shrink-0">
                    <span class="text-amber-700 font-bold text-sm">${c.name.charAt(0).toUpperCase()}</span>
                </div>
                <div>
                    <p class="text-sm font-semibold text-emerald-950">${c.name}</p>
                    <p class="text-xs text-stone-400">${c.email || ''}</p>
                </div>
            </label>
        `).join('');
    });

function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-img').src = e.target.result;
            document.getElementById('avatar-img').classList.remove('hidden');
            document.getElementById('avatar-icon').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
