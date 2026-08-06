@extends('admin.layouts.master')

@section('content')
<div class="container mx-auto px-4 py-6 sm:py-8 antialiased text-gray-800">
    <!-- Header Summary Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 sm:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">အသုံးပြုသူများ စီမံခန့်ခွဲခြင်း</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">စနစ်အတွင်းရှိ အက်ဒမင်များနှင့် အသုံးပြုသူအားလုံးကို စစ်ဆေး၊ ရှာဖွေ၊ ဖျက်သိမ်းနိုင်ပါသည်။</p>
        </div>
        <div class="flex items-center">
            <a href="{{ route('admin.users.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                အက်ဒမင်အသစ်ထည့်ရန်
            </a>
        </div>
    </div>

    <!-- Navigation Tabs (Scrollable on small devices) -->
    <div class="border-b border-gray-200 mb-6 overflow-x-auto scrollbar-none">
        <nav class="flex gap-6 min-w-max" aria-label="Tabs">
            <a href="{{ route('admin.users.index', ['tab' => 'admin']) }}" class="shrink-0 border-b-2 px-1 pb-4 text-sm font-semibold transition-colors {{ $tab === 'admin' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                အက်ဒမင်များ (Admins)
            </a>
            <a href="{{ route('admin.users.index', ['tab' => 'user']) }}" class="shrink-0 border-b-2 px-1 pb-4 text-sm font-semibold transition-colors {{ $tab === 'user' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                အသုံးပြုသူများ (Users)
            </a>
        </nav>
    </div>

    <!-- Main Content Display -->
    @if($users->isNotEmpty())
        <!-- 1. Desktop & Tablet View: Traditional Table (Hidden on Mobile) -->
        <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            <th class="px-6 py-4">အမည် / အီးမေးလ်</th>
                            <th class="px-6 py-4">ဖုန်းနံပါတ်</th>
                            <th class="px-6 py-4">အဆင့်အတန်း</th>
                            <th class="px-6 py-4">နေရပ်လိပ်စာ</th>
                            <th class="px-6 py-4 text-right">လုပ်ဆောင်ချက်</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($users as $item)
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900 truncate max-w-xs" title="{{ $item->name }}">{{ $item->name }}</div>
                                <div class="text-xs text-gray-400 mt-0.5 break-all">{{ $item->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-medium whitespace-nowrap">
                                {{ $item->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-medium uppercase ring-1 ring-inset {{ $item->role === 'admin' ? 'bg-blue-50 text-blue-700 ring-blue-700/10' : 'bg-gray-50 text-gray-600 ring-gray-500/10' }}">
                                    {{ $item->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                <div class="line-clamp-2">
                                    {{ implode('၊ ', array_filter([$item->region, $item->township, $item->village])) ?: '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.show', $item->id) }}" class="p-1.5 text-gray-400 hover:text-green-600 rounded-lg hover:bg-gray-100 transition-colors" title="အသေးစိတ်ကြည့်ရန်">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    <button type="button" onclick="confirmDelete('{{ $item->id }}', '{{ $item->name }}')" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-gray-100 transition-colors" title="ပယ်ဖျက်ရန်">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.users.destroy', $item->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. Mobile View: Responsive Card Grid (Visible on Mobile only) -->
        <div class="block md:hidden space-y-4 mb-6">
            @foreach($users as $item)
            <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm space-y-3">
                <!-- Card Header (Name and Role Badge) -->
                <div class="flex items-start justify-between gap-2">
                    <div class="min-w-0">
                        <div class="font-bold text-gray-950 text-base truncate">{{ $item->name }}</div>
                        <div class="text-xs text-gray-400 mt-0.5 break-all">{{ $item->email }}</div>
                    </div>
                    <span class="inline-flex items-center shrink-0 rounded-md px-2 py-0.5 text-xs font-medium uppercase ring-1 ring-inset {{ $item->role === 'admin' ? 'bg-blue-50 text-blue-700 ring-blue-700/10' : 'bg-gray-50 text-gray-600 ring-gray-500/10' }}">
                        {{ $item->role }}
                    </span>
                </div>

                <!-- Card Details -->
                <div class="grid grid-cols-2 gap-y-2 pt-2 border-t border-gray-50 text-xs text-gray-600">
                    <div>
                        <span class="block text-gray-400 font-medium mb-0.5">ဖုန်းနံပါတ်</span>
                        <span class="font-semibold text-gray-800">{{ $item->phone ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 font-medium mb-0.5">နေရပ်လိပ်စာ</span>
                        <span class="font-medium text-gray-800 break-words line-clamp-2">
                            {{ implode('၊ ', array_filter([$item->region, $item->township, $item->village])) ?: '-' }}
                        </span>
                    </div>
                </div>

                <!-- Card Actions -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                    <a href="{{ route('admin.users.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 hover:bg-green-50 text-gray-600 hover:text-green-600 font-semibold rounded-xl text-xs transition-colors border border-gray-150">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        ကြည့်မည်
                    </a>
                    <button type="button" onclick="confirmDelete('{{ $item->id }}', '{{ $item->name }}')" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50/50 hover:bg-red-50 text-red-600 font-semibold rounded-xl text-xs transition-colors border border-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                        ဖျက်မည်
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination Section -->
        @if($users->hasPages())
        <div class="px-4 py-3 sm:px-6 sm:py-4 bg-gray-50 rounded-2xl border border-gray-200 shadow-sm">
            {{ $users->links() }}
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-12 text-center text-gray-400 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-3 text-gray-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            ပြသရန် အချက်အလက်မရှိပါ။
        </div>
    @endif
</div>

<script>
    // SweetAlert2 ဖြင့် ဖျက်ရန် အတည်ပြုချက်တောင်းခြင်း
    function confirmDelete(id, name) {
        Swal.fire({
            title: "သေချာပါသလား?",
            text: `"${name}" ၏ အကောင့်အား စနစ်အတွင်းမှ ထာဝရ ဖျက်သိမ်းပါမည်။`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "သေချာသည်၊ ဖျက်မည်",
            cancelButtonText: "မဖျက်တော့ပါ",
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl text-sm font-semibold',
                cancelButton: 'rounded-xl text-sm font-semibold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
@endsection
