{{-- Single Comment Partial (used by AJAX + initial load) --}}
<div class="bg-white rounded-2xl border border-stone-100 p-4 sm:p-5" id="comment-{{ $comment->id }}">
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                <span class="text-emerald-700 text-xs font-bold">{{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}</span>
            </div>
            <div>
                <p class="text-sm font-semibold text-stone-700">{{ $comment->user->name ?? 'Deleted' }}</p>
                <p class="text-[11px] text-stone-400">{{ $comment->created_at->diffForHumans() }}</p>
            </div>
        </div>
        @if(auth()->check() && auth()->id() === $comment->user_id)
            <button onclick="deleteComment({{ $comment->id }})" class="text-stone-400 hover:text-red-500 transition text-xs">
                <i class="fa-solid fa-trash"></i>
            </button>
        @endif
    </div>

    <p class="text-sm text-stone-600 leading-relaxed mb-3">{{ $comment->body }}</p>

    @if(auth()->check())
        <button onclick="document.getElementById('reply-{{ $comment->id }}').classList.toggle('open')"
                class="text-xs text-emerald-700 font-semibold hover:underline">
            <i class="fa-solid fa-reply mr-1"></i> ပြန်ဖြေရန်
        </button>
        <div id="reply-{{ $comment->id }}" class="reply-box mt-3">
            <div class="flex gap-2">
                <input type="text" id="reply-input-{{ $comment->id }}" maxlength="1000"
                       class="flex-1 text-sm bg-stone-50 border border-stone-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition placeholder-stone-400"
                       placeholder="ပြန်စကား..." onkeydown="if(event.key==='Enter')submitReply({{ $comment->id }})">
                <button onclick="submitReply({{ $comment->id }})" class="bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
    @endif

    {{-- Replies --}}
    @if(isset($comment->replies) && $comment->replies->count() > 0)
        <div class="mt-4 ml-6 space-y-3 border-l-2 border-stone-100 pl-4">
            @foreach($comment->replies as $reply)
                @include('user.news._comment', ['comment' => $reply])
            @endforeach
        </div>
    @endif
</div>
