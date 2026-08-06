@extends('user.layouts.master')

@section('bdy')
<div class="max-w-4xl mx-auto px-4">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('chat.index') }}" class="text-emerald-600 hover:text-emerald-800">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-xl font-bold text-emerald-950 font-[Bricolage_Grotesque]">အသေးစိတ်</h1>
    </div>

    <div class="bg-white rounded-2xl border border-stone-100 overflow-hidden">
        {{-- Avatar --}}
        <div class="flex flex-col items-center py-8 bg-gradient-to-b from-emerald-50 to-white">
            @if(isset($user))
                <div class="w-24 h-24 bg-amber-100 rounded-full flex items-center justify-center mb-3">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <span class="text-amber-700 font-bold text-3xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
                <h2 class="font-bold text-xl text-emerald-950">{{ $user->name }}</h2>
                <p class="text-sm text-stone-400">{{ $user->email }}</p>
            @elseif(isset($chat) && $chat->type === 'group')
                <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mb-3">
                    @if($chat->avatar)
                        <img src="{{ asset('storage/' . $chat->avatar) }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <i class="fa-solid fa-users text-emerald-600 text-3xl"></i>
                    @endif
                </div>
                <h2 class="font-bold text-xl text-emerald-950">{{ $chat->name }}</h2>
                <p class="text-sm text-stone-400">{{ $chat->participants->count() }} ဦး ပါဝင်သည်</p>
            @endif
        </div>

        {{-- Actions --}}
        <div class="p-4 space-y-2">
            <a href="#" class="flex items-center gap-3 p-3 hover:bg-stone-50 rounded-xl transition">
                <i class="fa-solid fa-bell text-stone-400 w-5"></i>
                <span class="text-sm text-emerald-950">အသံပိတ်ရန်</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 hover:bg-stone-50 rounded-xl transition">
                <i class="fa-solid fa-image text-stone-400 w-5"></i>
                <span class="text-sm text-emerald-950">မီဒီယာ၊ ဖိုင်များ</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 hover:bg-stone-50 rounded-xl transition">
                <i class="fa-solid fa-search text-stone-400 w-5"></i>
                <span class="text-sm text-emerald-950">စကားပြောမှုရှာဖွေရန်</span>
            </a>
        </div>
    </div>
</div>
@endsection
