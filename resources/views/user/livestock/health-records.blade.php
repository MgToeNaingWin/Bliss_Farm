{{-- resources/views/livestock/health-records.blade.php --}}
@extends('user.layouts.master')

@section('bdy')
    <div class="py-10 bg-emerald-50/40 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-emerald-950">ကျန်းမာရေး မှတ်တမ်းများ</h2>
                    <p class="text-sm text-emerald-700 mt-1">ကာကွယ်ဆေး၊ ကုသမှု နှင့် ကျန်းမာရေး စစ်ဆေးမှု မှတ်တမ်းများ</p>
                </div>
                <button type="button" 
                        onclick="document.getElementById('healthModal').classList.remove('hidden')"
                        class="inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-md hover:shadow-lg transition duration-150">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    ကျန်းမာရေး မှတ်တမ်း အသစ်ထည့်မည်
                </button>
            </div>

            <!-- Table Card -->
            <div class="bg-white overflow-hidden shadow-lg shadow-emerald-900/5 sm:rounded-2xl border border-emerald-100">
                <div class="p-6">
                    @if($healthRecords->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-emerald-100">
                                <thead class="bg-emerald-50/60">
                                    <tr>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">ရက်စွဲ</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">အမျိုးအစား</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">ခေါင်းစဉ် / အကြောင်းအရာ</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">ဆေးဝါး / ပမာဏ</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">နောက်တစ်ကြိမ် ရက်စွဲ</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-emerald-900 uppercase tracking-wider">ကုန်ကျစရိတ်</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-emerald-50">
                                    @foreach($healthRecords as $record)
                                        <tr class="hover:bg-emerald-50/30 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                                {{ $record->record_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                                    {{ $record->type == 'vaccination' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' :
                                                       ($record->type == 'treatment' ? 'bg-amber-100 text-amber-800 border border-amber-200' :
                                                       ($record->type == 'checkup' ? 'bg-sky-100 text-sky-800 border border-sky-200' :
                                                       ($record->type == 'surgery' ? 'bg-rose-100 text-rose-800 border border-rose-200' : 'bg-gray-100 text-gray-800 border border-gray-200'))) }}">
                                                    {{ $record->type == 'vaccination' ? 'ကာကွယ်ဆေး' :
                                                       ($record->type == 'treatment' ? 'ကုသမှု' :
                                                       ($record->type == 'checkup' ? 'ကျန်းမာရေးစစ်ဆေးမှု' :
                                                       ($record->type == 'surgery' ? 'ခွဲစိတ်မှု' : 'အခြား'))) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-semibold text-emerald-950">
                                                {{ $record->title }}
                                                @if($record->description)
                                                    <p class="text-xs font-normal text-gray-500 mt-0.5">{{ $record->description }}</p>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                {{ $record->medication ?? '-' }}
                                                @if($record->dosage)
                                                    <span class="text-xs text-gray-500 font-medium">({{ $record->dosage }})</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                @if($record->next_due_date)
                                                    <span class="{{ $record->next_due_date->isPast() ? 'text-rose-600 font-bold' : 'font-medium' }}">
                                                        {{ $record->next_due_date->format('M d, Y') }}
                                                        @if($record->next_due_date->isPast())
                                                            <span class="text-xs text-rose-600 font-semibold block">(ရက်လွန်နေပါသည်)</span>
                                                        @endif
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-800">
                                                {{ $record->cost ? '$' . number_format($record->cost, 2) : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6 pt-4 border-t border-emerald-50">
                            {{ $healthRecords->links() }}
                        </div>
                    @else
                        <div class="text-center py-10">
                            <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">ကျန်းမာရေး မှတ်တမ်း မရှိသေးပါ။</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Health Record Modal -->
    <div id="healthModal" class="hidden fixed inset-0 bg-emerald-950/40 backdrop-blur-sm overflow-y-auto h-full w-full z-50 transition-all duration-200">
        <div class="relative top-10 mb-10 mx-auto p-6 sm:p-8 border border-emerald-100 w-full max-w-2xl shadow-2xl rounded-2xl bg-white">
            
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 mb-6 border-b border-emerald-100">
                <h3 class="text-lg font-bold text-emerald-950">ကျန်းမာရေး မှတ်တမ်း ထည့်သွင်းရန်</h3>
                <button type="button" 
                        onclick="document.getElementById('healthModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-emerald-700 rounded-lg p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('user.livestock.add-health-record', $livestock) }}" method="POST">
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

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            အမျိုးအစား <span class="text-red-500">*</span>
                        </label>
                        <select name="type" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                            <option value="vaccination">ကာကွယ်ဆေး (Vaccination)</option>
                            <option value="treatment">ကုသမှု (Treatment)</option>
                            <option value="checkup">ကျန်းမာရေးစစ်ဆေးမှု (Checkup)</option>
                            <option value="surgery">ခွဲစိတ်မှု (Surgery)</option>
                            <option value="other">အခြား (Other)</option>
                        </select>
                    </div>

                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            ခေါင်းစဉ် / အကြောင်းအရာ <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" required 
                               placeholder="ဥပမာ - FMD ကာကွယ်ဆေးထိုးခြင်း"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">အသေးစိတ် ဖော်ပြချက်</label>
                        <textarea name="description" rows="2" 
                                  placeholder="ရောဂါလက္ခဏာ သို့မဟုတ် ကုသမှု အသေးစိတ်..."
                                  class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150"></textarea>
                    </div>

                    <!-- Medication -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ဆေးဝါး အမည်</label>
                        <input type="text" name="medication" 
                               placeholder="ဥပမာ - Penicillin"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                    </div>

                    <!-- Dosage -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ဆေးပမာဏ / အဆောက်အဦး</label>
                        <input type="text" name="dosage" 
                               placeholder="ဥပမာ - 10 ml"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                    </div>

                    <!-- Next Due Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">နောက်တစ်ကြိမ် စစ်ဆေး/ထိုးရမည့် ရက်စွဲ</label>
                        <input type="date" name="next_due_date" 
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition duration-150">
                    </div>

                    <!-- Cost -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ကုန်ကျစရိတ် ($)</label>
                        <input type="number" step="0.01" name="cost" 
                               placeholder="0.00"
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
                            onclick="document.getElementById('healthModal').classList.add('hidden')"
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