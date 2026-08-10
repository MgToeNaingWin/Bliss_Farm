{{-- resources/views/livestock/dashboard.blade.php --}}
@extends('user.layouts.master')

@section('bdy')
    <div class="py-10 bg-emerald-50/40 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Dashboard Header -->
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-emerald-950">မွေးမြူရေး ဒက်ရှ်ဘုတ်</h2>
                    <p class="text-sm text-emerald-700 mt-1">မွေးမြူရေးတိရစ္ဆာန်များ၏ အခြေအနေနှင့် သတင်းအချက်အလက် အနှစ်ချုပ်</p>
                </div>
                <a href="{{ route('user.livestock.create') }}" 
                   class="inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-md hover:shadow-lg transition duration-150">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    တိရစ္ဆာန် အသစ်ထည့်ရန်
                </a>
            </div>

            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <!-- Total Livestock -->
                <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 sm:rounded-2xl p-6 border border-emerald-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">စုစုပေါင်း စာရင်း</p>
                        <p class="text-3xl font-extrabold text-emerald-950 mt-1">{{ number_format($stats['total']) }}</p>
                    </div>
                    <div class="p-3 bg-emerald-100 text-emerald-700 rounded-2xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>

                <!-- Active -->
                <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 sm:rounded-2xl p-6 border border-emerald-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">လက်ရှိ မွေးမြူထားဆဲ</p>
                        <p class="text-3xl font-extrabold text-emerald-600 mt-1">{{ number_format($stats['active']) }}</p>
                    </div>
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Male -->
                <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 sm:rounded-2xl p-6 border border-emerald-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-sky-600 uppercase tracking-wider">အထီး</p>
                        <p class="text-3xl font-extrabold text-sky-600 mt-1">{{ number_format($stats['male']) }}</p>
                    </div>
                    <div class="p-3 bg-sky-50 text-sky-600 rounded-2xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                </div>

                <!-- Female -->
                <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 sm:rounded-2xl p-6 border border-emerald-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-rose-500 uppercase tracking-wider">အမ</p>
                        <p class="text-3xl font-extrabold text-rose-500 mt-1">{{ number_format($stats['female']) }}</p>
                    </div>
                    <div class="p-3 bg-rose-50 text-rose-500 rounded-2xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content Grid Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Livestock -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-emerald-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-bold text-emerald-950">နောက်ဆုံး ထည့်သွင်းထားသည်များ</h3>
                            <a href="{{ route('user.livestock.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-800">
                                အားလုံးကြည့်မည် &rarr;
                            </a>
                        </div>

                        @if($recentLivestocks->count() > 0)
                            <ul class="divide-y divide-emerald-50">
                                @foreach($recentLivestocks as $livestock)
                                    <li class="py-3">
                                        <a href="{{ route('user.livestock.show', $livestock) }}" 
                                           class="group flex items-center justify-between p-2.5 rounded-xl hover:bg-emerald-50/60 transition duration-150">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                                                    {{ mb_substr($livestock->name ?? $livestock->tag_number, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900 group-hover:text-emerald-700 transition">
                                                        {{ $livestock->name ?? $livestock->tag_number }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 mt-0.5">
                                                        {{ ucfirst($livestock->type) }} • {{ ucfirst($livestock->gender) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    {{ ucfirst($livestock->status) }}
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-sm text-gray-500 mt-2">တိရစ္ဆာန် စာရင်း မရှိသေးပါ။</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Stats & Overview -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-emerald-100">
                    <div class="p-6">
                        <h3 class="text-base font-bold text-emerald-950 mb-4">အထွေထွေ စာရင်းအင်း</h3>
                        
                        <div class="space-y-6">
                            <!-- Distribution by Type -->
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">အမျိုးအစားအလိုက် ခွဲခြားမှု</p>
                                <div class="space-y-2">
                                    @foreach($types as $type => $count)
                                        <div class="flex items-center justify-between text-sm bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                            <span class="font-medium text-gray-700">{{ ucfirst($type) }}</span>
                                            <span class="font-bold text-emerald-800 bg-emerald-100/60 px-2.5 py-0.5 rounded-md text-xs">
                                                {{ number_format($count) }} ကောင်
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Upcoming Health Checks -->
                            <div class="pt-4 border-t border-emerald-50">
                                <div class="p-4 bg-amber-50 rounded-xl border border-amber-200 flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-semibold text-amber-800 uppercase tracking-wider">ကျန်းမာရေး စစ်ဆေးရန် ကျန်ရှိမှု</p>
                                        <p class="text-2xl font-black text-amber-900 mt-1">{{ number_format($healthStats) }} <span class="text-sm font-medium">ခု</span></p>
                                        <p class="text-xs text-amber-700 mt-0.5">ရှေ့လာမည့် ၇ ရက်အတွင်း စစ်ဆေးရန်လိုအပ်ပါသည်</p>
                                    </div>
                                    <div class="p-3 bg-amber-100 text-amber-700 rounded-xl">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Quick Actions Footer Card -->
            <div class="mt-6 bg-emerald-900 overflow-hidden shadow-md sm:rounded-2xl text-white">
                <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-white">လုပ်ဆောင်ချက်များ</h3>
                        <p class="text-xs text-emerald-200 mt-0.5">လိုအပ်သော လုပ်ဆောင်ချက်များကို လျင်မြန်စွာ ပြုလုပ်ပါ</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('user.livestock.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-emerald-950 font-semibold text-xs rounded-xl shadow transition duration-150">
                            + အသစ်ထည့်သွင်းမည်
                        </a>
                        <a href="{{ route('user.livestock.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-emerald-800 hover:bg-emerald-700 text-emerald-100 font-semibold text-xs rounded-xl border border-emerald-700 transition duration-150">
                            စာရင်းအားလုံး ကြည့်မည်
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection