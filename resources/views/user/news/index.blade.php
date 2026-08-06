@extends('user.layouts.master')
@section('bdy')
<style>
    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }
    .news-card { transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease; }
    .news-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(6, 95, 70, 0.1); }
    .gradient-text { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 40%, #d97706 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    @media (prefers-reduced-motion: reduce) { .reveal { opacity: 1; transform: none; transition: none; } }
</style>

<!-- ══ HERO ══ -->
<section class="relative overflow-hidden">
    <div class="relative bg-gradient-to-br from-emerald-800 via-emerald-900 to-emerald-950 text-white rounded-b-[2rem] px-6 sm:px-10 py-8 sm:py-10 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>
        <div class="absolute -right-20 -top-20 w-72 h-72 bg-amber-400/10 rounded-full blur-3xl"></div>
        <div class="relative z-10 max-w-4xl">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/15 rounded-full px-3 py-1 mb-3">
                <i class="fa-solid fa-newspaper text-amber-300 text-[10px]"></i>
                <span class="font-[Playfair_Display] text-amber-200 text-xs italic">News & Knowledge</span>
            </div>
            <h1 class="font-[Bricolage_Grotesque] text-2xl sm:text-3xl font-extrabold leading-tight tracking-tight">
                သတင်းနှင့် <span class="gradient-text">ဗဟုသုတ</span>
            </h1>
            <p class="text-emerald-100/60 text-sm mt-2 max-w-xl">မွေးမြူရေးနှင့် စိုက်ပျိုးရေးဆိုင်ရာ နောက်ဆုံးရ သတင်းများနှင့် အသုံးဝင်သည့် ဗဟုသုတဆောင်းပါးများ</p>

            {{-- Search Bar --}}
            <form action="{{ route('newsIndex') }}" method="GET" class="mt-5">
                <div class="relative max-w-lg">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="သတင်းရှာဖွေပါ..."
                           class="w-full bg-white/10 backdrop-blur-sm border border-white/20 text-white placeholder-emerald-200/50 text-sm rounded-xl px-4 py-2.5 pl-10 focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-transparent transition">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-emerald-200/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    @if(request('search'))
                        <a href="{{ route('newsIndex') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-emerald-200/50 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>

<!-- ══ NEWS GRID ══ -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-4 relative z-10 pb-16">
    @if(request('search'))
        <div class="flex items-center gap-2 mt-6 mb-2 text-sm text-stone-500">
            <span>"{{ request('search') }}" ရလဒ်</span>
            <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-0.5 rounded-md">{{ $news->total() }}</span>
            <span>ခု တွေ့ရှိပါသည်</span>
            <a href="{{ route('newsIndex') }}" class="text-emerald-700 text-xs font-semibold hover:underline ml-1">ရှင်းရန်</a>
        </div>
    @endif

    @if($news->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach($news as $index => $item)
                @php
                    $imageName = $item->{'news-img'} ?? null;
                @endphp
                <a href="{{ route('newsShow', $item->id) }}"
                   class="news-card reveal bg-white border border-stone-100 rounded-2xl overflow-hidden shadow-sm group block"
                   style="transition-delay: {{ $index * 0.05 }}s">

                    <!-- Image -->
                    <div class="h-44 w-full overflow-hidden relative bg-stone-100">
                        @if($imageName && file_exists(public_path('newsImage/' . $imageName)))
                            <img src="{{ asset('newsImage/' . $imageName) }}"
                                 alt="{{ $item->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-stone-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                </svg>
                            </div>
                        @endif
                        <span class="absolute top-3 right-3 bg-emerald-800/90 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-sm">
                            {{ $item->writer ?? 'Thukha Farm' }}
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="p-5 space-y-2">
                        <h3 class="font-[Bricolage_Grotesque] text-base font-bold text-stone-800 group-hover:text-emerald-700 transition-colors leading-snug line-clamp-2">
                            {{ $item->title }}
                        </h3>
                        <p class="text-stone-500 text-xs leading-relaxed line-clamp-2">
                            {{ Str::limit($item->description, 100, '...') }}
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class="px-5 pb-5 flex items-center justify-between">
                        <div class="flex items-center gap-3 text-[11px] text-stone-400">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-eye"></i> {{ number_format($item->view_count ?? 0) }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-regular fa-comment"></i> {{ $item->comments_count ?? 0 }}
                            </span>
                        </div>
                        <span class="text-emerald-700 text-xs font-bold inline-flex items-center gap-1 group-hover:gap-2 transition-all duration-300">
                            ဖတ်ရန်
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($news->hasPages())
            <div class="mt-8">
                {{ $news->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-16 text-center mt-8">
            <i class="fa-solid fa-newspaper text-stone-300 text-4xl mb-3"></i>
            <h3 class="font-[Bricolage_Grotesque] text-lg font-bold text-stone-800 mb-1">သတင်းများ မရှိသေးပါ</h3>
            <p class="text-sm text-stone-500">သတင်းအသစ်များ ထည့်သွင်းပြီးသည့်အခါ ဤနေရာတွင် ပေါ်လာပါမည်။</p>
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
