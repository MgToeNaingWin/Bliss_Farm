@extends('user.layouts.master')

@section('bdy')
<style>
    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }
    .disease-card { transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease; }
    .disease-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(6, 95, 70, 0.1); }
    .gradient-text { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 40%, #d97706 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    @media (prefers-reduced-motion: reduce) { .reveal { opacity: 1; transform: none; transition: none; } }
</style>

<!-- ══ HERO ══ -->
<section class="relative overflow-hidden">
    <div class="relative bg-gradient-to-br from-emerald-800 via-emerald-900 to-emerald-950 text-white rounded-b-[2rem] px-6 sm:px-10 py-8 sm:py-10 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>
        <div class="absolute -right-20 -top-20 w-72 h-72 bg-amber-400/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-4xl">
            <a href="{{ route('diseaseList') }}" class="inline-flex items-center gap-1.5 text-emerald-300/70 hover:text-white text-xs font-medium mb-3 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                အားလုံး ပြန်ကြည့်ရန်
            </a>
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/15 rounded-full px-3 py-1 mb-3">
                <i class="fa-solid fa-paw text-emerald-300 text-[10px]"></i>
                <span class="font-[Playfair_Display] text-emerald-200 text-xs italic">{{ $animalType->type_title }}</span>
            </div>
            <h1 class="font-[Bricolage_Grotesque] text-2xl sm:text-3xl font-extrabold leading-tight tracking-tight">
                {{ $animalType->type_title }} <span class="gradient-text">ရောဂါများ</span>
            </h1>
            @if($animalType->type_desc)
                <p class="text-emerald-100/60 text-sm mt-2 max-w-xl">{{ $animalType->type_desc }}</p>
            @endif
        </div>
    </div>
</section>

<!-- ══ DISEASES GRID ══ -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-4 relative z-10 pb-16">
    <div class="flex items-center gap-2 mt-6 mb-4 text-sm text-stone-500">
        <span>စုစုပေါင်း</span>
        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-0.5 rounded-md">{{ $diseases->total() }}</span>
        <span>ခု</span>
    </div>

    @if($diseases->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($diseases as $index => $disease)
                <a href="{{ route('userDiseaseDetail', $disease->id) }}"
                   class="disease-card reveal bg-white border border-stone-100 rounded-2xl overflow-hidden shadow-sm group block"
                   style="transition-delay: {{ $index * 0.05 }}s">
                    <!-- Image -->
                    <div class="h-44 w-full overflow-hidden relative bg-stone-100">
                        @if($disease->disease_img && file_exists(public_path('diseaseImage/' . $disease->disease_img)))
                            <img src="{{ asset('diseaseImage/' . $disease->disease_img) }}"
                                 alt="{{ $disease->disease_title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-stone-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-5 space-y-2">
                        <h3 class="font-[Bricolage_Grotesque] text-base font-bold text-stone-800 group-hover:text-emerald-700 transition-colors leading-snug line-clamp-2">
                            {{ $disease->disease_title }}
                        </h3>
                        <p class="text-stone-500 text-xs leading-relaxed line-clamp-2">
                            {{ Str::limit($disease->disease_desc, 100, '...') }}
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class="px-5 pb-5 flex items-center justify-between">
                        <div class="flex items-center gap-3 text-[11px] text-stone-400">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-eye"></i> {{ number_format($disease->view_count ?? 0) }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-regular fa-comment"></i> {{ $disease->comments_count ?? 0 }}
                            </span>
                        </div>
                        <span class="text-emerald-700 text-xs font-bold inline-flex items-center gap-1 group-hover:gap-2 transition-all duration-300">
                            အသေးစိတ်
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        @if($diseases->hasPages())
            <div class="mt-8">
                {{ $diseases->withQueryString()->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-16 text-center mt-4">
            <div class="w-16 h-16 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </div>
            <h3 class="font-[Bricolage_Grotesque] text-lg font-bold text-stone-800 mb-1">ရောဂါများ မရှိသေးပါ</h3>
            <p class="text-sm text-stone-500 mb-4">ဤတိရစ္ဆာန်အမျိုးအစားအတွက် ရောဂါအချက်အလက်များ မထည့်သွင်းရသေးပါ။</p>
            <a href="{{ route('diseaseList') }}" class="inline-flex items-center gap-2 bg-emerald-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-emerald-600 transition">
                <i class="fa-solid fa-arrow-left text-xs"></i> ပြန်ကြည့်ရန်
            </a>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(function(el) { observer.observe(el); });
});
</script>
@endsection
