@extends('user.layouts.master')

@section('bdy')
<div class="max-w-4xl mx-auto px-4">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('chat.index') }}" class="text-emerald-600 hover:text-emerald-800">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>
        <h1 class="text-xl font-bold text-emerald-950 font-[Bricolage_Grotesque]">ချိန်ညှိချက်များ</h1>
    </div>

    <div class="bg-white rounded-2xl border border-stone-100 divide-y divide-stone-100">
        <div class="p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-bell text-stone-400 w-5"></i>
                <span class="text-sm text-emerald-950">အသံကြော်ငြာများ</span>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-stone-200 peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
            </label>
        </div>

        <div class="p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-image text-stone-400 w-5"></i>
                <span class="text-sm text-emerald-950">ဓာတ်ပုံ အလိုအလျောက် ဒေါင်းလုဒ်</span>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer">
                <div class="w-11 h-6 bg-stone-200 peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
            </label>
        </div>

        <div class="p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-video text-stone-400 w-5"></i>
                <span class="text-sm text-emerald-950">ဗီဒီယို အလိုအလျောက် ဒေါင်းလုဒ်</span>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer">
                <div class="w-11 h-6 bg-stone-200 peer-focus:ring-2 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
            </label>
        </div>

        <a href="#" class="p-4 flex items-center gap-3 hover:bg-stone-50 transition">
            <i class="fa-solid fa-download text-stone-400 w-5"></i>
            <span class="text-sm text-emerald-950">စကားပြောမှု ဒေါင်းလုဒ်</span>
        </a>

        <a href="#" class="p-4 flex items-center gap-3 hover:bg-stone-50 transition">
            <i class="fa-solid fa-trash text-red-400 w-5"></i>
            <span class="text-sm text-red-500">စကားပြောမှုအားလုံး ဖျက်ရန်</span>
        </a>
    </div>
</div>
@endsection
