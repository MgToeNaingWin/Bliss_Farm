@extends('user.layouts.master')

@section('bdy')
    <div class="py-10 bg-emerald-50/40 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-emerald-950">အစာကျွေးမွေးမှု မှတ်တမ်းများ</h2>
                    <p class="text-sm text-emerald-700 mt-1">နေ့စဉ် အစာပေးဝေခဲ့သည့် အချက်အလက် စာရင်းများ</p>
                </div>
                <button type="button" 
                        onclick="document.getElementById('feedingModal').classList.remove('hidden')"
                        class="inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-md hover:shadow-lg transition duration-150">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    အစာကျွေးမှတ်တမ်း အသစ်ထည့်မည်
                </button>
            </div>

            <!-- Table Card -->
            <div class="bg-white overflow-hidden shadow-lg shadow-emerald-900/5 sm:rounded-2xl border border-emerald-100">
                <div class="p-6">
                    @if($feedingRecords->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-emerald-100">
                                <thead class="bg-emerald-50/60">
                                    <tr>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">ရက်စွဲ</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">အစာ အမျိုးအစား</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">ပမာဏ</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">ယူနစ်</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">အချိန်</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">မှတ်ချက်</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-emerald-50">
                                    @foreach($feedingRecords as $record)
                                        <tr class="hover:bg-emerald-50/30 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                                {{ $record->record_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-emerald-950">
                                                {{ $record->feed_type }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-700">
                                                {{ number_format($record->quantity, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $record->unit }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $record->feeding_time ? $record->feeding_time->format('H:i') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                                {{ $record->notes ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6 pt-4 border-t border-emerald-50">
                            {{ $feedingRecords->links() }}
                        </div>
                    @else
                        <div class="text-center py-10">
                            <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">အစာကျွေးမွေးမှု မှတ်တမ်း မရှိသေးပါ။</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Feeding Record Modal -->
    <div id="feedingModal" class="hidden fixed inset-0 bg-emerald-950/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-200">
        <div class="relative top-20 mx-auto p-6 sm:p-8 border border-emerald-100 w-full max-w-2xl shadow-2xl rounded-2xl bg-white">
            
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 mb-6 border-b border-emerald-100">
                <h3 class="text-lg font-bold text-emerald-950">အစာကျွေးမွေးမှု မှတ်တမ်း ထည့်သွင်းရန်</h3>
                <button type="button" 
                        onclick="document.getElementById('feedingModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-emerald-700 rounded-lg p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('user.livestock.add-feeding-record', $livestock) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    
                    <!-- Record Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            ရက်စွဲ <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="record_date" required 
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                    </div>

                    <!-- Feed Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            အစာ အမျိုးအစား <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="feed_type" required 
                               placeholder="ဥပမာ - မြက်ခြောက်၊ ဖိအစာ၊ အာဟာရစာ"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            ပမာဏ <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="quantity" required 
                               placeholder="0.00"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                    </div>

                    <!-- Unit -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ယူနစ်</label>
                        <input type="text" name="unit" value="kg" 
                               placeholder="kg, lbs စသည်ဖြင့်"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                    </div>

                    <!-- Feeding Time -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ကျွေးမွေးသည့် အချိန်</label>
                        <input type="time" name="feeding_time" 
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">မှတ်ချက်</label>
                        <textarea name="notes" rows="2" 
                                  placeholder="ထပ်ဆောင်း မှတ်ချက်များ ရေးသားပါ..."
                                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150"></textarea>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-emerald-100">
                    <button type="button" 
                            onclick="document.getElementById('feedingModal').classList.add('hidden')"
                            class="px-5 py-2.5 bg-gray-100 border border-gray-300 text-gray-700 font-medium text-xs rounded-lg uppercase tracking-wider hover:bg-gray-200 transition duration-150">
                        မလုပ်တော့ပါ
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center px-5 py-2.5 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-md hover:shadow-lg transition duration-150">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        သိမ်းဆည်းမည်
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection