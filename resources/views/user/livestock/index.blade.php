{{-- resources/views/user/livestock/index.blade.php --}}
@extends('user.layouts.master')

@section('bdy')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">စီမံခန့်ခွဲမှု</h2>
                <a href="{{ route('user.livestock.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    <i class="fa-solid fa-plus mr-2"></i> အသစ်ထည့်ရန်
                </a>
            </div>

            <!-- Tabs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 px-6 pt-4">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <a href="{{ route('user.livestock.index') }}?tab=all"
                           class="{{ ($activeTab ?? 'all') == 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            <i class="fa-solid fa-list mr-2"></i> အားလုံး
                        </a>
                        <a href="{{ route('user.livestock.index') }}?tab=health"
                           class="{{ ($activeTab ?? 'all') == 'health' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            <i class="fa-solid fa-heart-pulse mr-2"></i> ကျန်းမာရေးမှတ်တမ်း
                        </a>
                        <a href="{{ route('user.livestock.index') }}?tab=feeding"
                           class="{{ ($activeTab ?? 'all') == 'feeding' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            <i class="fa-solid fa-utensils mr-2"></i> အစာကျွေးမှတ်တမ်း
                        </a>
                        <a href="{{ route('user.livestock.index') }}?tab=reports"
                           class="{{ ($activeTab ?? 'all') == 'reports' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            <i class="fa-solid fa-file-chart-column mr-2"></i> အစီရင်ခံစာများ
                        </a>
                    </nav>
                </div>

                <div class="p-6">
                    @if(($activeTab ?? 'all') == 'all')
                        <!-- Filters -->
                        <form method="GET" action="{{ route('user.livestock.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <input type="hidden" name="tab" value="all">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">ရှာဖွေရန်</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="တဂ်၊ အမည်၊ မျိုးစိတ်...">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">အမျိုးအစား</label>
                                <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">အားလုံး</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">အမျိုးအစား</label>
                                <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">အားလုံး</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>အထီး</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>အမ</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">အခြေအနေ</label>
                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">အားလုံး</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>တက်ကြွ</option>
                                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>ရောင်းပြီး</option>
                                    <option value="deceased" {{ request('status') == 'deceased' ? 'selected' : '' }}>သေဆုံး</option>
                                    <option value="transferred" {{ request('status') == 'transferred' ? 'selected' : '' }}>လွှဲပြောင်း</option>
                                </select>
                            </div>
                            <div class="md:col-span-4 flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    <i class="fa-solid fa-search mr-2"></i> ရှာဖွေရန်
                                </button>
                                <a href="{{ route('user.livestock.index') }}" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                    <i class="fa-solid fa-undo mr-2"></i> ပြန်လည်သတ်မှတ်
                                </a>
                            </div>
                        </form>

                        <!-- Livestock Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">တဂ်နံပါတ်</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">အမည်</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">အမျိုးအစား</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">လိင်</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">အလေးချိန်</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">အခြေအနေ</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">လုပ်ဆောင်ချက်</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($livestocks as $livestock)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $livestock->tag_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $livestock->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ ucfirst($livestock->type) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $livestock->gender == 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                    {{ $livestock->gender == 'male' ? 'အထီး' : 'အမ' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $livestock->weight ? $livestock->weight . ' kg' : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $livestock->status == 'active' ? 'bg-green-100 text-green-800' :
                                                       ($livestock->status == 'sold' ? 'bg-yellow-100 text-yellow-800' :
                                                       ($livestock->status == 'deceased' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                                    {{ $livestock->status == 'active' ? 'တက်ကြွ' :
                                                       ($livestock->status == 'sold' ? 'ရောင်းပြီး' :
                                                       ($livestock->status == 'deceased' ? 'သေဆုံး' : 'လွှဲပြောင်း')) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('user.livestock.show', $livestock) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <a href="{{ route('user.livestock.edit', $livestock) }}" class="text-green-600 hover:text-green-900 mr-3">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                                <form action="{{ route('user.livestock.destroy', $livestock) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">တိရစ္ဆာန်မရှိပါ။</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $livestocks->links() }}
                        </div>

                    @elseif(($activeTab ?? 'all') == 'health')
                        <!-- Health Records Content -->
                        <div class="py-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">ကျန်းမာရေးမှတ်တမ်းများ</h3>
                            <p class="text-gray-500 mb-4">တိရစ္ဆာန်တစ်ကောင်ကို ရွေးချယ်ပြီး ၎င်း၏ ကျန်းမာရေးမှတ်တမ်းများကို ကြည့်ရှုပါ။</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @forelse($livestocks as $livestock)
                                    <a href="{{ route('user.livestock.health-records', $livestock) }}"
                                       class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $livestock->name ?? $livestock->tag_number }}</div>
                                                <div class="text-sm text-gray-500">{{ ucfirst($livestock->type) }} • {{ $livestock->gender == 'male' ? 'အထီး' : 'အမ' }}</div>
                                                <div class="text-xs text-gray-400 mt-1">တဂ်: {{ $livestock->tag_number }}</div>
                                            </div>
                                            <i class="fa-solid fa-chevron-right text-gray-400"></i>
                                        </div>
                                        <div class="text-xs text-blue-600 mt-2">
                                            <i class="fa-solid fa-heart-pulse mr-1"></i> ကျန်းမာရေးမှတ်တမ်းများကြည့်ရန် →
                                        </div>
                                    </a>
                                @empty
                                    <div class="col-span-3 text-center text-gray-500 py-8">
                                        <i class="fa-solid fa-heart-pulse text-4xl text-gray-300 mb-2 block"></i>
                                        တိရစ္ဆာန်မရှိပါ။
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    @elseif(($activeTab ?? 'all') == 'feeding')
                        <!-- Feeding Records Content -->
                        <div class="py-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">အစာကျွေးမှတ်တမ်းများ</h3>
                            <p class="text-gray-500 mb-4">တိရစ္ဆာန်တစ်ကောင်ကို ရွေးချယ်ပြီး ၎င်း၏ အစာကျွေးမှတ်တမ်းများကို ကြည့်ရှုပါ။</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @forelse($livestocks as $livestock)
                                    <a href="{{ route('user.livestock.feeding-records', $livestock) }}"
                                       class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $livestock->name ?? $livestock->tag_number }}</div>
                                                <div class="text-sm text-gray-500">{{ ucfirst($livestock->type) }} • {{ $livestock->gender == 'male' ? 'အထီး' : 'အမ' }}</div>
                                                <div class="text-xs text-gray-400 mt-1">တဂ်: {{ $livestock->tag_number }}</div>
                                            </div>
                                            <i class="fa-solid fa-chevron-right text-gray-400"></i>
                                        </div>
                                        <div class="text-xs text-blue-600 mt-2">
                                            <i class="fa-solid fa-utensils mr-1"></i> အစာကျွေးမှတ်တမ်းများကြည့်ရန် →
                                        </div>
                                    </a>
                                @empty
                                    <div class="col-span-3 text-center text-gray-500 py-8">
                                        <i class="fa-solid fa-utensils text-4xl text-gray-300 mb-2 block"></i>
                                        တိရစ္ဆာန်မရှိပါ။
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    @elseif(($activeTab ?? 'all') == 'reports')
                        <!-- Reports Content -->
                        <div class="py-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">အစီရင်ခံစာများ</h3>
                            <p class="text-gray-500 mb-4">သင့်တိရစ္ဆာန်များ၏ အစီရင်ခံစာများကို ကြည့်ရှုပါ။</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">ကျန်းမာရေးအစီရင်ခံစာ</h4>
                                            <p class="text-sm text-gray-600 mt-1">ကျန်းမာရေးမှတ်တမ်းများ၏ အကျဉ်းချုပ်</p>
                                            <div class="mt-3">
                                                <span class="text-xs bg-blue-200 text-blue-800 px-2 py-1 rounded">အသစ်</span>
                                            </div>
                                        </div>
                                        <i class="fa-solid fa-file-medical text-3xl text-blue-400"></i>
                                    </div>
                                    <a href="#" class="inline-flex items-center mt-4 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        အစီရင်ခံစာထုတ်ရန် <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </a>
                                </div>

                                <div class="p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border border-green-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">အစာကျွေးမှုအစီရင်ခံစာ</h4>
                                            <p class="text-sm text-gray-600 mt-1">အစာကျွေးမှတ်တမ်းများ၏ အကျဉ်းချုပ်</p>
                                            <div class="mt-3">
                                                <span class="text-xs bg-green-200 text-green-800 px-2 py-1 rounded">အသစ်</span>
                                            </div>
                                        </div>
                                        <i class="fa-solid fa-file-pen text-3xl text-green-400"></i>
                                    </div>
                                    <a href="#" class="inline-flex items-center mt-4 text-green-600 hover:text-green-800 text-sm font-medium">
                                        အစီရင်ခံစာထုတ်ရန် <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </a>
                                </div>

                                <div class="p-6 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">စာရင်းအစီရင်ခံစာ</h4>
                                            <p class="text-sm text-gray-600 mt-1">လက်ရှိတိရစ္ဆာန်စာရင်း</p>
                                        </div>
                                        <i class="fa-solid fa-file-invoice text-3xl text-yellow-400"></i>
                                    </div>
                                    <a href="#" class="inline-flex items-center mt-4 text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                        အစီရင်ခံစာထုတ်ရန် <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </a>
                                </div>

                                <div class="p-6 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg border border-purple-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">အခြေအနေအစီရင်ခံစာ</h4>
                                            <p class="text-sm text-gray-600 mt-1">တိရစ္ဆာန်အခြေအနေ ဖြန့်ဖြူးမှု</p>
                                        </div>
                                        <i class="fa-solid fa-chart-pie text-3xl text-purple-400"></i>
                                    </div>
                                    <a href="#" class="inline-flex items-center mt-4 text-purple-600 hover:text-purple-800 text-sm font-medium">
                                        အစီရင်ခံစာထုတ်ရန် <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
