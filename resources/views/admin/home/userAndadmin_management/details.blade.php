@extends('admin.layouts.master')

@section('content')
<div class="container mx-auto px-4 py-6 sm:py-8 max-w-2xl antialiased text-gray-800">
    <!-- Top Actions (Responsive Layout) -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}?tab={{ $user->role }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 rounded-lg px-2 py-1 -ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span>စာရင်းသို့ပြန်သွားရန်</span>
        </a>
    </div>

    <!-- Profile Detail Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Header Banner Pattern (Responsive Height) -->
        <div class="h-28 sm:h-36 bg-gradient-to-r from-green-500 to-emerald-500 flex items-end px-4 sm:px-6 pb-4 relative">
            <span class="absolute top-4 right-4 rounded-md bg-white/20 backdrop-blur-md px-2.5 py-1 text-xs font-semibold uppercase text-white tracking-wider shadow-sm">
                {{ $user->role }}
            </span>
        </div>

        <!-- Profile Image & Basic Info Wrapper (Mobile: Centered, Desktop: Left-aligned) -->
        <div class="px-4 sm:px-6 relative flex flex-col sm:flex-row items-center sm:items-end gap-4 -mt-12 sm:-mt-16 border-b border-gray-100 pb-6 text-center sm:text-left">
            <!-- Profile Avatar -->
            <div class="relative w-24 h-24 sm:w-32 sm:h-32 rounded-2xl overflow-hidden bg-gray-100 border-4 border-white shadow-md flex-shrink-0">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                @else
                    <!-- Fallback SVG Placeholder with User's Initial letter -->
                    <div class="w-full h-full bg-green-50 flex items-center justify-center text-green-600 text-3xl sm:text-4xl font-bold uppercase select-none">
                        {{ Str::substr($user->name, 0, 1) }}
                    </div>
                @endif
            </div>

            <!-- User Name and Email (Responsive Width & Text Wrapping) -->
            <div class="pt-2 sm:pt-0 w-full min-w-0">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight truncate sm:whitespace-normal sm:overflow-visible" title="{{ $user->name }}">
                    {{ $user->name }}
                </h2>
                <p class="text-sm text-gray-500 mt-1 break-all max-w-full font-medium">
                    {{ $user->email }}
                </p>
            </div>
        </div>

        <!-- Information List Content Section -->
        <div class="p-4 sm:p-6">
            <!-- Information List Grid -->
            <div class="grid grid-cols-1 gap-1 sm:gap-2 text-sm">

                <!-- Phone Item -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-50 gap-1 sm:gap-4">
                    <span class="font-medium text-gray-400 shrink-0">ဖုန်းနံပါတ်</span>
                    <span class="text-gray-800 font-semibold break-all">{{ $user->phone ?? '-' }}</span>
                </div>

                <!-- Region Item -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-50 gap-1 sm:gap-4">
                    <span class="font-medium text-gray-400 shrink-0">တိုင်းဒေသကြီး / ပြည်နယ်</span>
                    <span class="text-gray-800 font-semibold break-words sm:text-right">{{ $user->region ?? '-' }}</span>
                </div>

                <!-- Township Item -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-50 gap-1 sm:gap-4">
                    <span class="font-medium text-gray-400 shrink-0">မြို့နယ်</span>
                    <span class="text-gray-800 font-semibold break-words sm:text-right">{{ $user->township ?? '-' }}</span>
                </div>

                <!-- Village Item -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 border-b border-gray-50 gap-1 sm:gap-4">
                    <span class="font-medium text-gray-400 shrink-0">ရပ်ကွက် / ကျေးရွာ</span>
                    <span class="text-gray-800 font-semibold break-words sm:text-right">{{ $user->village ?? '-' }}</span>
                </div>

                <!-- Created Date Item -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center py-3 gap-1 sm:gap-4">
                    <span class="font-medium text-gray-400 shrink-0">အကောင့်စတင်ဖွင့်လှစ်သည့်ရက်</span>
                    <span class="text-gray-600 font-medium sm:text-right">{{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : '-' }}</span>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
