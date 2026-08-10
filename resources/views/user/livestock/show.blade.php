{{-- resources/views/user/livestock/show.blade.php --}}
@extends('user.layouts.master')

@section('bdy')
    <div class="py-10 bg-emerald-50/40 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Basic Information Card -->
            <div class="bg-white overflow-hidden shadow-lg shadow-emerald-900/5 sm:rounded-2xl border border-emerald-100 p-6 sm:p-8">
                <div class="border-b border-emerald-100 pb-4 mb-6">
                    <h3 class="text-xl font-bold text-emerald-950">အခြေခံ အချက်အလက်များ</h3>
                    <p class="text-xs text-emerald-700 mt-1">မွေးမြူရေးတိရစ္ဆာန်၏ အသေးစိတ် အချက်အလက်များ</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">နားကပ်နံပါတ် / Tag Number</p>
                        <p class="text-base font-bold text-emerald-950 mt-1">{{ $livestock->tag_number }}</p>
                    </div>

                    <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">အမည်</p>
                        <p class="text-base font-bold text-emerald-950 mt-1">{{ $livestock->name ?? '-' }}</p>
                    </div>

                    <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">အမျိုးအစား</p>
                        <p class="text-base font-bold text-emerald-950 mt-1">{{ ucfirst($livestock->type) }}</p>
                    </div>

                    <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">လိင်</p>
                        <p class="text-base font-bold text-emerald-950 mt-1">
                            {{ $livestock->gender == 'male' ? 'အထီး' : ($livestock->gender == 'female' ? 'အမ' : ucfirst($livestock->gender)) }}
                        </p>
                    </div>

                    <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">မွေးနေ့</p>
                        <p class="text-base font-bold text-emerald-950 mt-1">{{ $livestock->date_of_birth ? $livestock->date_of_birth->format('M d, Y') : '-' }}</p>
                    </div>

                    <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">အသက်</p>
                        <p class="text-base font-bold text-emerald-950 mt-1">{{ $livestock->age ? $livestock->age . ' နှစ်' : '-' }}</p>
                    </div>

                    <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">မျိုးစိတ်</p>
                        <p class="text-base font-bold text-emerald-950 mt-1">{{ $livestock->breed ?? '-' }}</p>
                    </div>

                    <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">အရောင်</p>
                        <p class="text-base font-bold text-emerald-950 mt-1">{{ $livestock->color ?? '-' }}</p>
                    </div>

                    <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">အလေးချိန်</p>
                        <p class="text-base font-bold text-emerald-950 mt-1">{{ $livestock->weight ? $livestock->weight . ' kg' : '-' }}</p>
                    </div>

                    <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">အခြေအနေ</p>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $livestock->status == 'active' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' :
                                   ($livestock->status == 'sold' ? 'bg-amber-100 text-amber-800 border border-amber-200' :
                                   ($livestock->status == 'deceased' ? 'bg-rose-100 text-rose-800 border border-rose-200' : 'bg-gray-100 text-gray-800 border border-gray-200')) }}">
                                {{ $livestock->status == 'active' ? 'လက်ရှိမွေးမြူထားဆဲ' :
                                   ($livestock->status == 'sold' ? 'ရောင်းချပြီး' :
                                   ($livestock->status == 'deceased' ? 'သေဆုံး' : ucfirst($livestock->status))) }}
                            </span>
                        </p>
                    </div>

                    <div class="bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">မိဘအချက်အလက်</p>
                        <p class="text-base font-bold text-emerald-950 mt-1">
                            @if($livestock->parent)
                                <a href="{{ route('user.livestock.show', $livestock->parent) }}" class="text-emerald-600 hover:text-emerald-800 underline">
                                    {{ $livestock->parent->name ?? $livestock->parent->tag_number }}
                                </a>
                            @else
                                -
                            @endif
                        </p>
                    </div>

                    <div class="md:col-span-3 bg-emerald-50/30 p-4 rounded-xl border border-emerald-50">
                        <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">မှတ်ချက်</p>
                        <p class="text-sm font-medium text-gray-700 mt-1">{{ $livestock->notes ?? 'မှတ်ချက် မရှိပါ' }}</p>
                    </div>
                </div>
            </div>

            <!-- Health Records Section -->
            <div class="bg-white overflow-hidden shadow-lg shadow-emerald-900/5 sm:rounded-2xl border border-emerald-100 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-emerald-100">
                    <div>
                        <h3 class="text-xl font-bold text-emerald-950">ကျန်းမာရေး မှတ်တမ်းများ</h3>
                        <p class="text-xs text-emerald-700 mt-0.5">နောက်ဆုံး ထည့်သွင်းထားသော ကျန်းမာရေးဆိုင်ရာ မှတ်တမ်းများ</p>
                    </div>
                    <button onclick="document.getElementById('healthModal').classList.remove('hidden')"
                            class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-md transition duration-150">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        မှတ်တမ်း အသစ်ထည့်မည်
                    </button>
                </div>

                @if($healthRecords->count() > 0)
                    <div class="space-y-3">
                        @foreach($healthRecords as $record)
                            <div class="p-4 rounded-xl border border-emerald-50 bg-emerald-50/20 hover:bg-emerald-50/40 transition duration-150 flex flex-col sm:flex-row justify-between gap-2 sm:items-center">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <p class="font-bold text-emerald-950 text-base">{{ $record->title }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-100 text-emerald-800">
                                            {{ $record->type == 'vaccination' ? 'ကာကွယ်ဆေး' :
                                               ($record->type == 'treatment' ? 'ကုသမှု' :
                                               ($record->type == 'checkup' ? 'ကျန်းမာရေးစစ်ဆေးမှု' :
                                               ($record->type == 'surgery' ? 'ခွဲစိတ်မှု' : 'အခြား'))) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-emerald-700 mt-1">
                                        ရက်စွဲ - {{ $record->record_date->format('M d, Y') }}
                                        @if($record->medication)
                                            • ဆေးဝါး: <span class="font-medium text-gray-700">{{ $record->medication }} {{ $record->dosage ? '(' . $record->dosage . ')' : '' }}</span>
                                        @endif
                                    </p>
                                </div>
                                @if($record->next_due_date)
                                    <div class="text-left sm:text-right bg-white sm:bg-transparent p-2 sm:p-0 rounded-lg border sm:border-none border-emerald-100">
                                        <p class="text-xs font-semibold text-gray-500">နောက်တစ်ကြိမ် ရက်စွဲ</p>
                                        <p class="text-xs font-bold text-rose-600 mt-0.5">{{ $record->next_due_date->format('M d, Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-3 border-t border-emerald-50">
                        <a href="{{ route('user.livestock.health-records', $livestock) }}" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-800">
                            ကျန်းမာရေး မှတ်တမ်း အားလုံး ကြည့်ရှုရန်
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <p class="text-sm text-gray-500 py-4 text-center">ကျန်းမာရေး မှတ်တမ်း မရှိသေးပါ။</p>
                @endif
            </div>

            <!-- Feeding Records Section -->
            <div class="bg-white overflow-hidden shadow-lg shadow-emerald-900/5 sm:rounded-2xl border border-emerald-100 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-emerald-100">
                    <div>
                        <h3 class="text-xl font-bold text-emerald-950">အစာကျွေးမွေးမှု မှတ်တမ်းများ</h3>
                        <p class="text-xs text-emerald-700 mt-0.5">နောက်ဆုံး ထည့်သွင်းထားသော အစာကျွေးမွေးမှု မှတ်တမ်းများ</p>
                    </div>
                    <button onclick="document.getElementById('feedingModal').classList.remove('hidden')"
                            class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-md transition duration-150">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        မှတ်တမ်း အသစ်ထည့်မည်
                    </button>
                </div>

                @if($feedingRecords->count() > 0)
                    <div class="space-y-3">
                        @foreach($feedingRecords as $record)
                            <div class="p-4 rounded-xl border border-emerald-50 bg-emerald-50/20 hover:bg-emerald-50/40 transition duration-150 flex flex-col sm:flex-row justify-between gap-2 sm:items-center">
                                <div>
                                    <p class="font-bold text-emerald-950 text-base">{{ $record->feed_type }}</p>
                                    <p class="text-xs text-emerald-700 mt-1">
                                        ရက်စွဲ - {{ $record->record_date->format('M d, Y') }} • ပမာဏ - <span class="font-bold text-emerald-800">{{ $record->quantity }} {{ $record->unit }}</span>
                                    </p>
                                </div>
                                @if($record->feeding_time)
                                    <div class="text-left sm:text-right">
                                        <p class="text-xs font-semibold text-gray-500">အချိန်</p>
                                        <p class="text-xs font-bold text-emerald-950 mt-0.5">{{ $record->feeding_time->format('H:i') }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-3 border-t border-emerald-50">
                        <a href="{{ route('user.livestock.feeding-records', $livestock) }}" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-800">
                            အစာကျွေးမွေးမှု မှတ်တမ်း အားလုံး ကြည့်ရှုရန်
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <p class="text-sm text-gray-500 py-4 text-center">အစာကျွေးမွေးမှု မှတ်တမ်း မရှိသေးပါ။</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Health Record Modal -->
    <div id="healthModal" class="hidden fixed inset-0 bg-emerald-950/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-200">
        <div class="relative top-10 mb-10 mx-auto p-6 sm:p-8 border border-emerald-100 w-full max-w-2xl shadow-2xl rounded-2xl bg-white">
            <div class="flex justify-between items-center pb-4 mb-6 border-b border-emerald-100">
                <h3 class="text-lg font-bold text-emerald-950">ကျန်းမာရေး မှတ်တမ်း ထည့်သွင်းရန်</h3>
                <button type="button" onclick="document.getElementById('healthModal').classList.add('hidden')" class="text-gray-400 hover:text-emerald-700 rounded-lg p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('user.livestock.add-health-record', $livestock) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ရက်စွဲ <span class="text-red-500">*</span></label>
                        <input type="date" name="record_date" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">အမျိုးအစား <span class="text-red-500">*</span></label>
                        <select name="type" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="vaccination">ကာကွယ်ဆေး (Vaccination)</option>
                            <option value="treatment">ကုသမှု (Treatment)</option>
                            <option value="checkup">ကျန်းမာရေးစစ်ဆေးမှု (Checkup)</option>
                            <option value="surgery">ခွဲစိတ်မှု (Surgery)</option>
                            <option value="other">အခြား (Other)</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ခေါင်းစဉ် / အကြောင်းအရာ <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">အသေးစိတ် ဖော်ပြချက်</label>
                        <textarea name="description" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ဆေးဝါး အမည်</label>
                        <input type="text" name="medication" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ဆေးပမာဏ</label>
                        <input type="text" name="dosage" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">နောက်တစ်ကြိမ် ရက်စွဲ</label>
                        <input type="date" name="next_due_date" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ကုန်ကျစရိတ် ($)</label>
                        <input type="number" step="0.01" name="cost" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">မှတ်ချက်</label>
                        <textarea name="notes" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-emerald-100">
                    <button type="button" onclick="document.getElementById('healthModal').classList.add('hidden')"
                            class="px-5 py-2.5 bg-gray-100 border border-gray-300 text-gray-700 font-medium text-xs rounded-lg uppercase tracking-wider hover:bg-gray-200">
                        မလုပ်တော့ပါ
                    </button>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 shadow-md">
                        သိမ်းဆည်းမည်
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Feeding Record Modal -->
    <div id="feedingModal" class="hidden fixed inset-0 bg-emerald-950/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-200">
        <div class="relative top-10 mb-10 mx-auto p-6 sm:p-8 border border-emerald-100 w-full max-w-2xl shadow-2xl rounded-2xl bg-white">
            <div class="flex justify-between items-center pb-4 mb-6 border-b border-emerald-100">
                <h3 class="text-lg font-bold text-emerald-950">အစာကျွေးမွေးမှု မှတ်တမ်း ထည့်သွင်းရန်</h3>
                <button type="button" onclick="document.getElementById('feedingModal').classList.add('hidden')" class="text-gray-400 hover:text-emerald-700 rounded-lg p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('user.livestock.add-feeding-record', $livestock) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ရက်စွဲ <span class="text-red-500">*</span></label>
                        <input type="date" name="record_date" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">အစာ အမျိုးအစား <span class="text-red-500">*</span></label>
                        <input type="text" name="feed_type" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ပမာဏ <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="quantity" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ယူနစ်</label>
                        <input type="text" name="unit" value="kg" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ကျွေးမွေးသည့် အချိန်</label>
                        <input type="time" name="feeding_time" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">မှတ်ချက်</label>
                        <textarea name="notes" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-emerald-100">
                    <button type="button" onclick="document.getElementById('feedingModal').classList.add('hidden')"
                            class="px-5 py-2.5 bg-gray-100 border border-gray-300 text-gray-700 font-medium text-xs rounded-lg uppercase tracking-wider hover:bg-gray-200">
                        မလုပ်တော့ပါ
                    </button>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 shadow-md">
                        သိမ်းဆည်းမည်
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection