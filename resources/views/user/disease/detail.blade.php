@extends('user.layouts.master')

@section('bdy')
<style>
    .reveal { opacity: 0; transform: translateY(20px); transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }
    .reaction-btn { transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
    .reaction-btn:active { transform: scale(0.95); }
    .reaction-btn.active.like { background: #dbeafe; color: #2563eb; border-color: #93c5fd; }
    .reaction-btn.active.helpful { background: #dcfce7; color: #16a34a; border-color: #86efac; }
    .reaction-btn.active.thanks { background: #fef3c7; color: #d97706; border-color: #fcd34d; }
    .reply-box { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
    .reply-box.open { max-height: 200px; }
    .reading-progress { position: fixed; top: 0; left: 0; height: 3px; background: linear-gradient(90deg, #047857, #fbbf24); z-index: 100; transition: width 0.15s ease; }
    .back-to-top { position: fixed; bottom: 6rem; right: 1.5rem; z-index: 40; }
    .sidebar-link:hover .sidebar-title { color: #047857; }
    @media (prefers-reduced-motion: reduce) { .reveal { opacity: 1; transform: none; transition: none; } .reading-progress { display: none; } }
</style>

<div class="reading-progress" id="readingProgress"></div>

<!-- ═══════════════════ ARTICLE + SIDEBARS ═══════════════════ -->
<div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-16">

    <!-- Back Link -->
    <div class="mb-5">
        <a href="{{ route('showDisease', $disease->animal_type_id) }}" class="inline-flex items-center gap-1.5 text-sm text-stone-500 hover:text-emerald-700 transition font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            {{ $disease->animalType->type_title ?? '' }} ရောဂါများသို့ ပြန်သွားရန်
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- ══════ MAIN ARTICLE (8 cols) ══════ -->
        <article class="lg:col-span-8">
            {{-- Hero Image --}}
            <div class="reveal rounded-xl overflow-hidden bg-stone-100 mb-6">
                @if($disease->disease_img && file_exists(public_path('diseaseImage/' . $disease->disease_img)))
                    <img src="{{ asset('diseaseImage/' . $disease->disease_img) }}" alt="{{ $disease->disease_title }}" class="w-full h-64 sm:h-80 lg:h-[420px] object-cover">
                @else
                    <div class="w-full h-64 sm:h-80 lg:h-[420px] flex items-center justify-center bg-gradient-to-br from-stone-100 to-stone-50">
                        <svg class="w-20 h-20 text-stone-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                    </div>
                @endif
            </div>

            {{-- Meta --}}
            <div class="reveal flex flex-wrap items-center gap-2 mb-4">
                <span class="bg-emerald-600 text-white text-[11px] font-bold px-2.5 py-1 rounded">{{ $disease->animalType->type_title ?? 'N/A' }}</span>
                <span class="text-stone-400 text-xs">{{ $disease->created_at ? $disease->created_at->format('MMMM d, Y') : '' }}</span>
                <span class="text-stone-300">•</span>
                <span class="text-stone-400 text-xs flex items-center gap-1"><i class="fa-solid fa-eye text-[10px]"></i> {{ number_format($disease->view_count ?? 0) }}</span>
                <span class="text-stone-300">•</span>
                <span class="text-stone-400 text-xs flex items-center gap-1"><i class="fa-regular fa-clock text-[10px]"></i> {{ ceil(str_word_count($disease->disease_desc ?? '') / 200) }} min read</span>
            </div>

            {{-- Title --}}
            <h1 class="reveal font-[Bricolage_Grotesque] text-2xl sm:text-3xl lg:text-[2.1rem] font-extrabold text-stone-900 leading-[1.2] tracking-tight mb-5">
                {{ $disease->disease_title }}
            </h1>

            {{-- Description --}}
            <div class="reveal text-stone-700 leading-[1.85] space-y-4 mb-8">
                @php $paragraphs = array_filter(explode("\n", $disease->disease_desc ?? '')); @endphp
                @foreach($paragraphs as $paragraph)
                    @if(trim($paragraph) !== '')
                        <p class="text-[15px] sm:text-base">{{ trim($paragraph) }}</p>
                    @endif
                @endforeach
            </div>

            {{-- Symptoms, Prevention, Treatment --}}
            @if($disease->symptoms || $disease->prevent || $disease->treated)
                <div class="reveal grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    @if($disease->symptoms)
                        <div class="bg-red-50/60 border border-red-100 rounded-xl p-5">
                            <div class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center mb-3">
                                <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                            </div>
                            <h3 class="text-sm font-bold text-red-900 mb-2">လက္ခဏာများ</h3>
                            <p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">{{ $disease->symptoms }}</p>
                        </div>
                    @endif
                    @if($disease->prevent)
                        <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-5">
                            <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mb-3">
                                <i class="fa-solid fa-shield-halved text-sm"></i>
                            </div>
                            <h3 class="text-sm font-bold text-blue-900 mb-2">ကာကွယ်နည်း</h3>
                            <p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">{{ $disease->prevent }}</p>
                        </div>
                    @endif
                    @if($disease->treated)
                        <div class="bg-emerald-50/60 border border-emerald-100 rounded-xl p-5">
                            <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center mb-3">
                                <i class="fa-solid fa-briefcase-medical text-sm"></i>
                            </div>
                            <h3 class="text-sm font-bold text-emerald-900 mb-2">ကုသနည်း</h3>
                            <p class="text-xs text-stone-600 leading-relaxed whitespace-pre-line">{{ $disease->treated }}</p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Reactions --}}
            <div class="reveal flex flex-wrap items-center gap-2 mb-8 pb-6 border-b border-stone-100" id="reactions-container">
                <button type="button" onclick="toggleReaction('like')"
                        class="reaction-btn like {{ $userReaction === 'like' ? 'active' : '' }} flex items-center gap-1.5 bg-stone-50 border border-stone-200 text-stone-500 px-3.5 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all">
                    <i class="fa-solid fa-thumbs-up text-[10px]"></i> ကြိုက်တယ်
                    <span id="count-like" class="bg-white/80 text-[10px] px-1.5 py-0.5 rounded-md font-bold">{{ $reactions['like'] }}</span>
                </button>
                <button type="button" onclick="toggleReaction('helpful')"
                        class="reaction-btn helpful {{ $userReaction === 'helpful' ? 'active' : '' }} flex items-center gap-1.5 bg-stone-50 border border-stone-200 text-stone-500 px-3.5 py-1.5 rounded-lg text-xs font-semibold hover:bg-green-50 hover:text-green-600 hover:border-green-200 transition-all">
                    <i class="fa-solid fa-hand-holding-heart text-[10px]"></i> အသုံးဝင်တယ်
                    <span id="count-helpful" class="bg-white/80 text-[10px] px-1.5 py-0.5 rounded-md font-bold">{{ $reactions['helpful'] }}</span>
                </button>
                <button type="button" onclick="toggleReaction('thanks')"
                        class="reaction-btn thanks {{ $userReaction === 'thanks' ? 'active' : '' }} flex items-center gap-1.5 bg-stone-50 border border-stone-200 text-stone-500 px-3.5 py-1.5 rounded-lg text-xs font-semibold hover:bg-amber-50 hover:text-amber-600 hover:border-amber-200 transition-all">
                    <i class="fa-solid fa-heart text-[10px]"></i> ကျေးဇူးတင်တယ်
                    <span id="count-thanks" class="bg-white/80 text-[10px] px-1.5 py-0.5 rounded-md font-bold">{{ $reactions['thanks'] }}</span>
                </button>

                <div class="ml-auto flex items-center gap-2">
                    <span class="text-xs text-stone-400">မျှဝေရန်</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/user/disease/animals/detail/' . $disease->id)) }}" target="_blank" class="w-8 h-8 bg-stone-100 hover:bg-blue-100 text-stone-400 hover:text-blue-600 rounded-lg flex items-center justify-center transition text-sm"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url('/user/disease/animals/detail/' . $disease->id)) }}&text={{ urlencode($disease->disease_title) }}" target="_blank" class="w-8 h-8 bg-stone-100 hover:bg-sky-100 text-stone-400 hover:text-sky-500 rounded-lg flex items-center justify-center transition text-sm"><i class="fa-brands fa-twitter"></i></a>
                    <button onclick="copyLink()" id="copy-btn" class="w-8 h-8 bg-stone-100 hover:bg-emerald-100 text-stone-400 hover:text-emerald-600 rounded-lg flex items-center justify-center transition text-sm"><i class="fa-solid fa-link"></i></button>
                </div>
            </div>

            {{-- Comments --}}
            <div class="reveal">
                <h2 class="font-[Bricolage_Grotesque] text-lg font-bold text-stone-800 mb-4 flex items-center gap-2">
                    မှတ်ချက်များ <span id="comment-count" class="bg-stone-100 text-stone-500 text-xs font-bold px-2 py-0.5 rounded-md">{{ $comments->count() }}</span>
                </h2>

                @if(auth()->check())
                    <div class="flex gap-3 mb-5">
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                            <span class="text-emerald-700 text-xs font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1">
                            <textarea id="comment-body" rows="2" maxlength="1000"
                                      class="w-full text-sm text-stone-700 bg-stone-50 border border-stone-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-emerald-500 resize-none transition placeholder-stone-400"
                                      placeholder="မှတ်ချက်ရေးပါ..." onkeydown="if(event.key==='Enter' && event.ctrlKey)submitComment()"></textarea>
                            <div class="flex justify-end mt-1.5">
                                <button onclick="submitComment()" class="bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold px-4 py-1.5 rounded-lg transition">ပို့ရန်</button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-stone-50 border border-stone-100 rounded-lg p-3 text-center mb-5">
                        <p class="text-xs text-stone-500">မှတ်ချက်ရေးရန် <a href="{{ route('login') }}" class="text-emerald-700 font-bold hover:underline">အကောင့်ဝင်ပါ</a></p>
                    </div>
                @endif

                <div class="space-y-3" id="comments-list">
                    @forelse($comments->filter(fn($c) => !$c->parent_id) as $comment)
                        @include('user.disease._comment', ['comment' => $comment])
                    @empty
                        <div id="no-comments" class="text-center py-6">
                            <p class="text-xs text-stone-400">မှတ်ချက်များ မရှိသေးပါ။</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </article>

        <!-- ══════ SIDEBAR (4 cols) ══════ -->
        <aside class="lg:col-span-4 space-y-6">

            {{-- Related Diseases --}}
            <div class="bg-white border border-stone-100 rounded-xl p-5">
                <h3 class="font-[Bricolage_Grotesque] text-sm font-bold text-stone-900 mb-4 flex items-center gap-2">
                    <span class="w-1 h-4 bg-stone-900 rounded-full"></span> ဆက်စပ်ရောဂါများ
                </h3>
                <div class="space-y-4">
                    @forelse($relatedDiseases as $item)
                        <a href="{{ route('userDiseaseDetail', $item->id) }}" class="sidebar-link flex gap-3 group">
                            <div class="w-20 h-16 rounded-lg overflow-hidden bg-stone-100 flex-shrink-0">
                                @if($item->disease_img && file_exists(public_path('diseaseImage/' . $item->disease_img)))
                                    <img src="{{ asset('diseaseImage/' . $item->disease_img) }}" class="w-full h-full object-cover" alt="">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"><svg class="w-6 h-6 text-stone-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg></div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="sidebar-title text-[13px] font-bold text-stone-800 leading-snug line-clamp-2 transition-colors">{{ $item->disease_title }}</p>
                                <p class="text-[10px] text-stone-400 mt-1">{{ $item->created_at ? $item->created_at->format('MMM d, Y') : '' }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-stone-400 text-center py-4">ဆက်စပ်ရောဂါများ မရှိသေးပါ။</p>
                    @endforelse
                </div>
                <a href="{{ route('showDisease', $disease->animal_type_id) }}" class="block text-center text-xs font-semibold text-emerald-700 hover:text-emerald-800 mt-4 pt-3 border-t border-stone-100 transition">
                    ရောဂါအားလုံးကြည့်ရန် →
                </a>
            </div>

            {{-- Most Viewed --}}
            <div class="bg-white border border-stone-100 rounded-xl p-5">
                <h3 class="font-[Bricolage_Grotesque] text-sm font-bold text-stone-900 mb-4 flex items-center gap-2">
                    <span class="w-1 h-4 bg-amber-500 rounded-full"></span> Most Viewed
                </h3>
                <div class="space-y-4">
                    @forelse($topViewed as $index => $item)
                        <a href="{{ route('userDiseaseDetail', $item->id) }}" class="sidebar-link flex gap-3 group">
                            <span class="text-2xl font-extrabold text-stone-200 leading-none mt-0.5 w-6 flex-shrink-0">{{ $index + 1 }}</span>
                            <div class="min-w-0 flex-1">
                                <p class="sidebar-title text-[13px] font-bold text-stone-800 leading-snug line-clamp-2 transition-colors">{{ $item->disease_title }}</p>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span class="text-[10px] text-stone-400">{{ $item->created_at ? $item->created_at->format('MMM d') : '' }}</span>
                                    <span class="text-[10px] text-stone-300">•</span>
                                    <span class="text-[10px] text-stone-400 flex items-center gap-0.5"><i class="fa-solid fa-eye text-[8px]"></i> {{ number_format($item->view_count ?? 0) }}</span>
                                </div>
                            </div>
                            @if($item->disease_img && file_exists(public_path('diseaseImage/' . $item->disease_img)))
                                <img src="{{ asset('diseaseImage/' . $item->disease_img) }}" class="w-14 h-14 rounded-lg object-cover flex-shrink-0" alt="">
                            @endif
                        </a>
                    @empty
                        <p class="text-xs text-stone-400 text-center py-4">ရောဂါများ မရှိသေးပါ။</p>
                    @endforelse
                </div>
            </div>

        </aside>
    </div>
</div>

{{-- Back to Top --}}
<div class="back-to-top">
    <button onclick="window.scrollTo({top:0,behavior:'smooth'})" id="backToTop"
            class="w-10 h-10 bg-stone-900 hover:bg-stone-800 text-white rounded-xl shadow-lg flex items-center justify-center transition-all duration-300 opacity-0 translate-y-4 pointer-events-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18"/></svg>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reveal
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) { if (e.isIntersecting) e.target.classList.add('active'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(function(el) { observer.observe(el); });

    // Reading progress
    var bar = document.getElementById('readingProgress');
    window.addEventListener('scroll', function() {
        var s = document.documentElement.scrollTop, h = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        bar.style.width = (s / h * 100) + '%';
    });

    // Back to top
    var btt = document.getElementById('backToTop');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 400) { btt.classList.remove('opacity-0','translate-y-4','pointer-events-none'); }
        else { btt.classList.add('opacity-0','translate-y-4','pointer-events-none'); }
    });
});

function toggleReaction(type) {
    fetch('{{ route("reaction.toggle", $disease->id) }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: JSON.stringify({ type: type })
    }).then(function(r) { return r.json(); }).then(function(d) {
        document.getElementById('count-like').textContent = d.reactions.like;
        document.getElementById('count-helpful').textContent = d.reactions.helpful;
        document.getElementById('count-thanks').textContent = d.reactions.thanks;
        document.querySelectorAll('.reaction-btn').forEach(function(b) { b.classList.remove('active'); });
        if (d.active) { var a = document.querySelector('.reaction-btn.' + d.active); if (a) a.classList.add('active'); }
    });
}

function submitComment() {
    var body = document.getElementById('comment-body').value.trim();
    if (!body) return;
    fetch('{{ route("comment.store", $disease->id) }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: JSON.stringify({ body: body })
    }).then(function(r) { return r.json(); }).then(function(d) {
        if (d.success) {
            var nc = document.getElementById('no-comments'); if (nc) nc.remove();
            document.getElementById('comments-list').insertAdjacentHTML('afterbegin', d.html);
            document.getElementById('comment-body').value = '';
            document.getElementById('comment-count').textContent = d.count;
        }
    });
}

function submitReply(parentId) {
    var input = document.getElementById('reply-input-' + parentId);
    var body = input.value.trim();
    if (!body) return;
    fetch('{{ route("comment.store", $disease->id) }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: JSON.stringify({ body: body, parent_id: parentId })
    }).then(function(r) { return r.json(); }).then(function(d) {
        if (d.success) {
            var pc = document.getElementById('comment-' + parentId);
            var rc = pc.querySelector('.space-y-3');
            if (!rc) { rc = document.createElement('div'); rc.className = 'mt-3 ml-6 space-y-3 border-l-2 border-stone-100 pl-4'; pc.appendChild(rc); }
            rc.insertAdjacentHTML('beforeend', d.html);
            input.value = '';
            document.getElementById('reply-' + parentId).classList.remove('open');
            document.getElementById('comment-count').textContent = d.count;
        }
    });
}

function deleteComment(id) {
    if (!confirm('ဖျက်မလား?')) return;
    fetch('{{ url("/user/comment") }}/' + id, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    }).then(function(r) { return r.json(); }).then(function(d) {
        if (d.success) { var el = document.getElementById('comment-' + id); if (el) el.remove(); document.getElementById('comment-count').textContent = d.count; }
    });
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        var b = document.getElementById('copy-btn');
        b.innerHTML = '<i class="fa-solid fa-check text-emerald-600"></i>';
        setTimeout(function() { b.innerHTML = '<i class="fa-solid fa-link"></i>'; }, 2000);
    });
}
</script>
@endsection
