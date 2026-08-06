{{-- Single Comment Partial --}}
<div class="bg-white rounded-2xl border border-stone-100 p-4 sm:p-5 transition-all duration-200" id="comment-{{ $comment->id }}">
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                <span class="text-emerald-700 text-xs font-bold">{{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}</span>
            </div>
            <div>
                <p class="text-sm font-semibold text-stone-700">{{ $comment->user->name ?? 'Deleted' }}</p>
                <p class="text-[11px] text-stone-400">
                    {{ $comment->created_at ? $comment->created_at->diffForHumans() : 'ယခုပင်' }}
                </p>
            </div>
        </div>

        @if(auth()->check() && auth()->id() === $comment->user_id)
            <button type="button"
                    onclick="deleteComment({{ $comment->id }})"
                    class="text-stone-400 hover:text-red-500 transition text-xs p-1"
                    title="ဖျက်ရန်">
                <i class="fa-solid fa-trash"></i>
            </button>
        @endif
    </div>

    <p class="text-sm text-stone-600 leading-relaxed mb-3">{{ $comment->body }}</p>

    @if(auth()->check())
        <button type="button"
                onclick="document.getElementById('reply-{{ $comment->id }}').classList.toggle('hidden')"
                class="text-xs text-emerald-700 font-semibold hover:underline inline-flex items-center gap-1">
            <i class="fa-solid fa-reply text-[10px]"></i> ပြန်ဖြေရန်
        </button>

        {{-- Reply Input Box (Hidden by default) --}}
        <div id="reply-{{ $comment->id }}" class="hidden mt-3">
            <div class="flex gap-2">
                <input type="text"
                       id="reply-input-{{ $comment->id }}"
                       maxlength="1000"
                       class="flex-1 text-sm bg-stone-50 border border-stone-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition placeholder-stone-400"
                       placeholder="ပြန်စကား..."
                       onkeydown="if(event.key==='Enter'){ event.preventDefault(); submitReply({{ $comment->id }}); }">
                <button type="button"
                        onclick="submitReply({{ $comment->id }})"
                        class="bg-emerald-700 hover:bg-emerald-600 text-white text-xs font-semibold px-3 py-2 rounded-lg transition shrink-0 flex items-center justify-center min-w-[38px]">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
    @endif

    {{-- Nested Replies Container --}}
    <div id="replies-container-{{ $comment->id }}" class="mt-4 ml-6 space-y-3 border-l-2 border-stone-100 pl-4 @if(!isset($comment->replies) || $comment->replies->count() == 0) hidden @endif">
        @if(isset($comment->replies) && $comment->replies->count() > 0)
            @foreach($comment->replies as $reply)
                @include('user.disease._comment', ['comment' => $reply])
            @endforeach
        @endif
    </div>
</div>
<script>
// CSRF Header Configuration
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Submit Reply (AJAX - No Page Reload)
function submitReply(parentId) {
    const input = document.getElementById(`reply-input-${parentId}`);
    const body = input.value.trim();

    if (!body) return;

    fetch(`/comments/${parentId}/reply`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ body: body })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Unhide replies wrapper if hidden
            const container = document.getElementById(`replies-container-${parentId}`);
            container.classList.remove('hidden');

            // Insert new reply HTML dynamically
            container.insertAdjacentHTML('beforeend', data.html);

            // Reset input and hide reply box
            input.value = '';
            document.getElementById(`reply-${parentId}`).classList.add('hidden');
        }
    })
    .catch(error => console.error('Error submitting reply:', error));
}

// Delete Comment/Reply (AJAX - No Page Reload)
function deleteComment(commentId) {
    if (!confirm('ဤမှတ်ချက်ကို ဖျက်ရန် သေချာပါသလား။')) return;

    fetch(`/comments/${commentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const el = document.getElementById(`comment-${commentId}`);
            if (el) {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 200);
            }
        }
    })
    .catch(error => console.error('Error deleting comment:', error));
}
</script>
