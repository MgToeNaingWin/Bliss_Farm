@extends('user.layouts.master')
@section('bdy')

<!-- CSRF Token Meta Header -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* ================= DESIGN TOKENS ================= */
    :root {
        --sp-ink: #1B211C;
        --sp-forest: #24402F;
        --sp-forest-hover: #1A3022;
        --sp-brass: #B8863A;
        --sp-brass-light: #F7F3EB;
        --sp-sage: #93A692;
        --sp-rust: #A5482F;
        --sp-stone: #F6F3EB;
        --sp-paper: #FFFFFF;
        --sp-line: #E7E1D3;
        --sp-muted: #7A7A6E;
        --sp-radius: 16px;
        --sp-shadow: 0 10px 30px -10px rgba(27, 33, 28, 0.08);
    }

    .sp-wrap {
        max-width: 720px;
        margin: 24px auto;
        padding: 0 16px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        color: var(--sp-ink);
    }

    .sp-card {
        background: var(--sp-paper);
        border: 1px solid var(--sp-line);
        border-radius: var(--sp-radius);
        box-shadow: var(--sp-shadow);
        overflow: hidden;
        margin-bottom: 24px;
    }

    /* ---------- POST HEADER ---------- */
    .sp-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px 14px;
    }
    .sp-seller-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .sp-avatar-wrap {
        position: relative;
    }
    .sp-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--sp-line);
    }
    .sp-badge-verified {
        position: absolute;
        bottom: -2px;
        right: -2px;
        background: var(--sp-brass);
        color: white;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        display: grid;
        place-items: center;
        border: 2px solid #fff;
    }
    .sp-seller-name {
        font-weight: 700;
        font-size: 15px;
        color: var(--sp-ink);
        line-height: 1.2;
    }
    .sp-post-meta {
        font-size: 12.5px;
        color: var(--sp-muted);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 3px;
    }

    /* ---------- PRICING & BADGE ---------- */
    .sp-price-tag {
        text-align: right;
    }
    .sp-price-amount {
        font-size: 22px;
        font-weight: 800;
        color: var(--sp-forest);
        letter-spacing: -0.02em;
    }
    .sp-price-status {
        display: inline-block;
        background: #EBF3ED;
        color: var(--sp-forest);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 12px;
        letter-spacing: 0.04em;
    }

    /* ---------- ACTION DROPDOWN ---------- */
    .sp-dropdown {
        position: relative;
        display: inline-block;
    }
    .sp-dropdown-btn {
        background: none;
        border: none;
        font-size: 22px;
        cursor: pointer;
        color: var(--sp-muted);
        padding: 0 8px;
        line-height: 1;
        border-radius: 50%;
        transition: background 0.15s;
    }
    .sp-dropdown-btn:hover {
        background: var(--sp-stone);
        color: var(--sp-ink);
    }
    .sp-dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        background-color: #fff;
        min-width: 140px;
        box-shadow: 0px 8px 20px rgba(0,0,0,0.12);
        border-radius: 10px;
        z-index: 50;
        overflow: hidden;
        border: 1px solid var(--sp-line);
    }
    .sp-dropdown-content a, .sp-dropdown-content button {
        color: var(--sp-ink);
        padding: 10px 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        text-align: left;
        background: none;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }
    .sp-dropdown-content a:hover, .sp-dropdown-content button:hover {
        background-color: var(--sp-stone);
    }
    .sp-dropdown-content button.danger {
        color: var(--sp-rust);
    }
    .sp-dropdown:hover .sp-dropdown-content {
        display: block;
    }

    /* ---------- POST CONTENT ---------- */
    .sp-body {
        padding: 0 20px 16px;
    }
    .sp-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--sp-ink);
        margin-bottom: 8px;
        line-height: 1.35;
    }
    .sp-text {
        font-size: 14.5px;
        line-height: 1.55;
        color: #333;
        white-space: pre-line;
    }
    .sp-specs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 14px;
    }
    .sp-spec-chip {
        background: var(--sp-stone);
        border: 1px solid var(--sp-line);
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: var(--sp-forest);
    }

    /* ---------- MEDIA DISPLAY ---------- */
    .sp-single-media {
        position: relative;
        width: 100%;
        max-height: 480px;
        overflow: hidden;
        background: #111;
    }
    .sp-single-media img {
        width: 100%;
        height: 100%;
        max-height: 480px;
        object-fit: cover;
        display: block;
    }

    /* ---------- ACTION STRIP & COUNTERS ---------- */
    .sp-stats-bar {
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--sp-line);
        font-size: 13px;
        color: var(--sp-muted);
    }
    .sp-reaction-stack {
        display: flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
    }
    .sp-emoji-overlap {
        display: flex;
        align-items: center;
        margin-right: 4px;
    }
    .sp-emoji-overlap span {
        font-size: 15px;
        margin-left: -4px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 1px #fff;
    }
    .sp-emoji-overlap span:first-child { margin-left: 0; }

    .sp-actions-bar {
        display: grid;
        grid-template-columns: 1fr 1fr 1.2fr;
        padding: 6px 12px;
        border-bottom: 1px solid var(--sp-line);
        position: relative;
    }
    .sp-action-btn {
        background: none;
        border: none;
        padding: 10px 0;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--sp-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.15s, color 0.15s;
    }
    .sp-action-btn:hover {
        background: var(--sp-stone);
        color: var(--sp-ink);
    }
    .sp-action-btn svg {
        width: 18px;
        height: 18px;
    }
    .sp-action-btn.active {
        color: var(--sp-forest);
    }

    /* ---------- MYANMAR EMOJI REACTION POPUP ---------- */
    .sp-reaction-picker {
        position: absolute;
        top: -52px;
        left: 12px;
        background: var(--sp-paper);
        border: 1px solid var(--sp-line);
        border-radius: 30px;
        padding: 6px 12px;
        display: flex;
        gap: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        opacity: 0;
        pointer-events: none;
        transform: translateY(10px);
        transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 20;
    }
    .sp-actions-bar .sp-react-container:hover .sp-reaction-picker {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }
    .sp-emoji-btn {
        font-size: 22px;
        background: none;
        border: none;
        cursor: pointer;
        transition: transform 0.15s;
        line-height: 1;
    }
    .sp-emoji-btn:hover {
        transform: scale(1.35) translateY(-4px);
    }

    /* ---------- COMMENTS & REPLIES SECTION ---------- */
    .sp-comments-area {
        padding: 16px 20px 20px;
        background: #FAFAFA;
    }
    .sp-comment-input-wrap {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    .sp-comment-input {
        flex: 1;
        background: var(--sp-paper);
        border: 1px solid var(--sp-line);
        border-radius: 20px;
        padding: 10px 16px;
        font-size: 13.5px;
        outline: none;
        transition: border-color 0.15s;
    }
    .sp-comment-input:focus {
        border-color: var(--sp-brass);
    }
    .sp-send-btn {
        background: var(--sp-forest);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: background 0.15s;
    }
    .sp-send-btn:hover {
        background: var(--sp-forest-hover);
    }

    .sp-comment-item {
        margin-bottom: 14px;
    }
    .sp-comment-main-box {
        display: flex;
        gap: 10px;
    }
    .sp-comment-bubble {
        background: var(--sp-paper);
        border: 1px solid var(--sp-line);
        border-radius: 14px;
        padding: 8px 14px;
        max-width: 85%;
    }
    .sp-comment-user {
        font-weight: 700;
        font-size: 12.5px;
        color: var(--sp-ink);
    }
    .sp-comment-text {
        font-size: 13.5px;
        color: #333;
        margin-top: 2px;
    }
    .sp-comment-actions {
        display: flex;
        gap: 12px;
        font-size: 11.5px;
        color: var(--sp-muted);
        margin-top: 4px;
        padding-left: 4px;
    }
    .sp-reply-btn {
        font-weight: 700;
        cursor: pointer;
        color: var(--sp-forest);
        border: none;
        background: none;
        padding: 0;
    }
    .sp-reply-btn:hover {
        text-decoration: underline;
    }

    /* Nested Replies Style */
    .sp-replies-list {
        margin-left: 42px;
        margin-top: 8px;
        border-left: 2px solid var(--sp-line);
        padding-left: 12px;
    }
    .sp-reply-form {
        display: none;
        margin-left: 42px;
        margin-top: 8px;
        gap: 8px;
    }
    .sp-reply-form.active {
        display: flex;
    }
</style>

<div class="sp-wrap">
    @forelse($posts as $post)
    @php
        $userReaction = auth()->check() ? $post->reactions->where('user_id', auth()->id())->first() : null;

        $emojiMap = [
            'Like'      => '👍',
            'Love'      => '❤️',
            'Favorite'  => '⭐',
            'Wow'       => '😮',
        ];

        $myanmarTextMap = [
            'Like'      => 'ကြိုက်တယ်',
            'Love'      => 'ချစ်တယ်',
            'Favorite'  => 'အကြိုက်ဆုံး',
            'Wow'       => 'အံ့ဩတယ်',
        ];

        $currentEmoji = $userReaction ? ($emojiMap[$userReaction->type] ?? '👍') : '';
        $currentText  = $userReaction ? ($myanmarTextMap[$userReaction->type] ?? 'ကြိုက်တယ်') : 'ကြိုက်တယ်';
    @endphp
    <div class="sp-card" data-post-id="{{ $post->id }}">

        <!-- Header -->
        <div class="sp-header">
            <div class="sp-seller-info">
                <div class="sp-avatar-wrap">
                    <img src="{{ $post->user->profile_photo_path ? asset('storage/'.$post->user->profile_photo_path) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop' }}" class="sp-avatar" alt="Seller Avatar">
                    <div class="sp-badge-verified">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    </div>
                </div>
                <div>
                    <div class="sp-seller-name">{{ $post->user->name ?? 'Unknown Seller' }}</div>
                    <div class="sp-post-meta">
                        <span>{{ $post->created_at->diffForHumans() }}</span> • <span>{{ $post->location ?? 'Myanmar' }}</span>
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 12px;">
                <div class="sp-price-tag">
                    <div class="sp-price-amount">{{ number_format($post->price) }} Ks</div>
                    <div class="sp-price-status">For Sale</div>
                </div>

                <!-- Own Post Options Dropdown -->
                @if(auth()->check() && auth()->id() === $post->user_id)
                <div class="sp-dropdown">
                    <button class="sp-dropdown-btn" title="Options">⋮</button>
                    <div class="sp-dropdown-content">
                        <a href="{{ route('post.editPage', $post->id) }}">✏️ ပြင်ဆင်ရန်</a>
                        <button class="danger" onclick="deletePost({{ $post->id }}, this)">🗑️ ဖျက်ပစ်ရန်</button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Post Body -->
        <div class="sp-body">
            <h2 class="sp-title">{{ $post->title }}</h2>
            <div class="sp-text">{{ $post->description }}</div>

            <div class="sp-specs">
                <span class="sp-spec-chip">အမျိုးအစား: {{ ucfirst($post->category) }}</span>
                @if($post->phone)
                    <span class="sp-spec-chip">ဖုန်း: {{ $post->phone }}</span>
                @endif
            </div>
        </div>

        <!-- Post Photo -->
        @if($post->image)
            <div class="sp-single-media">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
            </div>
        @endif

        <!-- Reaction & Comment Counter Stats -->
        <div class="sp-stats-bar">
            <div class="sp-reaction-stack">
                <div class="sp-emoji-overlap">
                    <span>👍</span>
                    <span>❤️</span>
                    <span>⭐</span>
                </div>
                <span class="reactionCount">{{ $post->reactions_count ?? $post->reactions->count() }} တုံ့ပြန်မှုများ</span>
            </div>
            <div>
                <span class="commentCount">{{ $post->comments_count ?? $post->comments->count() }} မှတ်ချက်များ</span> •
                <span class="viewCount">{{ $post->views_count ?? 0 }} ကြည့်ရှုမှု</span>
            </div>
        </div>

        <!-- Myanmar Reactions Strip -->
        <div class="sp-actions-bar">
            <div class="sp-react-container" style="position: relative;">
                <!-- Emoji Hover Options -->
                <div class="sp-reaction-picker">
                    <button class="sp-emoji-btn" title="ကြိုက်တယ်" onclick="sendReaction({{ $post->id }}, 'Like', '👍', 'ကြိုက်တယ်')">👍</button>
                    <button class="sp-emoji-btn" title="ချစ်တယ်" onclick="sendReaction({{ $post->id }}, 'Love', '❤️', 'ချစ်တယ်')">❤️</button>
                    <button class="sp-emoji-btn" title="အကြိုက်ဆုံး" onclick="sendReaction({{ $post->id }}, 'Favorite', '⭐', 'အကြိုက်ဆုံး')">⭐</button>
                    <button class="sp-emoji-btn" title="အံ့ဩတယ်" onclick="sendReaction({{ $post->id }}, 'Wow', '😮', 'အံ့ဩတယ်')">😮</button>
                </div>

                <button class="sp-action-btn likeBtn {{ $userReaction ? 'active' : '' }}" onclick="sendReaction({{ $post->id }}, 'Like', '👍', 'ကြိုက်တယ်')">
                    <span class="defaultLikeIcon" style="{{ $userReaction ? 'display:none;' : '' }}">
                        <svg class="likeIcon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                    </span>
                    <span class="selectedEmoji" style="{{ $userReaction ? '' : 'display:none;' }}">{{ $currentEmoji }}</span>
                    <span class="likeText">{{ $userReaction ? $currentText : 'ကြိုက်တယ်' }}</span>
                </button>
            </div>

            <button class="sp-action-btn" onclick="focusCommentInput(this)">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                <span>မှတ်ချက်</span>
            </button>

            <button class="sp-action-btn" onclick="openOfferModal('{{ number_format($post->price) }}')" style="color: var(--sp-brass);">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                <span>ဈေးဆစ်ရန်</span>
            </button>
        </div>

        <!-- Comments & Reply Area -->
        <div class="sp-comments-area">
            <div class="sp-comment-input-wrap">
                <input type="text" class="sp-comment-input mainCommentInput" placeholder="မှတ်ချက်ရေးရန်..." onkeypress="handleCommentKeyPress(event, {{ $post->id }}, this)">
                <button class="sp-send-btn" onclick="addComment({{ $post->id }}, this)">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"></path></svg>
                </button>
            </div>

            <div class="commentsList">
                @foreach($post->comments->where('parent_id', null) as $comment)
                <div class="sp-comment-item" data-comment-id="{{ $comment->id }}">
                    <div class="sp-comment-main-box">
                        <img src="{{ $comment->user->profile_photo_path ? asset('storage/'.$comment->user->profile_photo_path) : 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=80&auto=format&fit=crop' }}" class="sp-avatar" style="width:32px; height:32px;" alt="User">
                        <div>
                            <div class="sp-comment-bubble">
                                <div class="sp-comment-user">{{ $comment->user->name ?? 'User' }}</div>
                                <div class="sp-comment-text">{{ $comment->comment }}</div>
                            </div>
                            <div class="sp-comment-actions">
                                <span>{{ $comment->created_at->diffForHumans() }}</span>
                                <button class="sp-reply-btn" onclick="toggleReplyForm(this)">Reply ပြန်ရန်</button>
                            </div>
                        </div>
                    </div>

                    <!-- Inline Reply Input Form -->
                    <div class="sp-reply-form">
                        <input type="text" class="sp-comment-input replyInput" placeholder="Reply ပြန်ရန်..." onkeypress="handleReplyKeyPress(event, {{ $post->id }}, {{ $comment->id }}, this)">
                        <button class="sp-send-btn" style="width: 34px; height: 34px;" onclick="addReply({{ $post->id }}, {{ $comment->id }}, this)">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"></path></svg>
                        </button>
                    </div>

                    <!-- Nested Sub-Replies List -->
                    <div class="sp-replies-list">
                        @foreach($comment->replies ?? [] as $reply)
                            <div class="sp-comment-main-box" style="margin-top: 8px;">
                                <img src="{{ $reply->user->profile_photo_path ? asset('storage/'.$reply->user->profile_photo_path) : 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=80&auto=format&fit=crop' }}" class="sp-avatar" style="width:26px; height:26px;" alt="User">
                                <div>
                                    <div class="sp-comment-bubble" style="padding: 6px 12px;">
                                        <div class="sp-comment-user" style="font-size: 11.5px;">{{ $reply->user->name ?? 'User' }}</div>
                                        <div class="sp-comment-text" style="font-size: 12.5px;">{{ $reply->comment }}</div>
                                    </div>
                                    <div class="sp-comment-actions">
                                        <span>{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
    @empty
        <div style="text-align: center; padding: 40px; color: var(--sp-muted);">
            <p>အရောင်းပို့စ်များ မရှိသေးပါ။</p>
        </div>
    @endforelse
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Send Reaction via AJAX
    function sendReaction(postId, type, emoji, mmText) {
        fetch("{{ route('post.reaction') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ post_id: postId, type: type })
        })
        .then(res => res.json())
        .then(data => {
            const card = document.querySelector(`.sp-card[data-post-id="${postId}"]`);
            const likeBtn = card.querySelector('.likeBtn');
            const likeText = card.querySelector('.likeText');
            const defaultSvg = card.querySelector('.defaultLikeIcon');
            const selectedEmoji = card.querySelector('.selectedEmoji');
            const reactionCount = card.querySelector('.reactionCount');

            if (data.status === 'removed') {
                likeBtn.classList.remove('active');
                likeText.innerText = 'ကြိုက်တယ်';
                defaultSvg.style.display = 'inline-block';
                selectedEmoji.style.display = 'none';
            } else {
                likeBtn.classList.add('active');
                likeText.innerText = mmText;
                defaultSvg.style.display = 'none';
                selectedEmoji.style.display = 'inline-block';
                selectedEmoji.innerText = emoji;
            }

            reactionCount.innerText = `${data.count} တုံ့ပြန်မှုများ`;
        })
        .catch(err => console.error(err));
    }

    // Toggle Inline Reply Form
    function toggleReplyForm(btn) {
        const item = btn.closest('.sp-comment-item');
        const form = item.querySelector('.sp-reply-form');
        form.classList.toggle('active');
        if (form.classList.contains('active')) {
            form.querySelector('.replyInput').focus();
        }
    }

    // Handle Enter Key for Comment & Reply
    function handleCommentKeyPress(e, postId, input) {
        if (e.key === 'Enter') addComment(postId, input);
    }

    function handleReplyKeyPress(e, postId, parentId, input) {
        if (e.key === 'Enter') addReply(postId, parentId, input);
    }

    // Add Comment AJAX
    function addComment(postId, element) {
        const card = element.closest('.sp-card');
        const input = card.querySelector('.mainCommentInput');
        const text = input.value.trim();

        if (!text) return;

        fetch("{{ route('post.comment') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ post_id: postId, comment: text })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const commentsList = card.querySelector('.commentsList');
                const commentCount = card.querySelector('.commentCount');

                const newComment = document.createElement('div');
                newComment.className = 'sp-comment-item';
                newComment.setAttribute('data-comment-id', data.comment.id);
                newComment.innerHTML = `
                    <div class="sp-comment-main-box">
                        <img src="${data.comment.user_avatar}" class="sp-avatar" style="width:32px; height:32px;" alt="User">
                        <div>
                            <div class="sp-comment-bubble">
                                <div class="sp-comment-user">${data.comment.user_name}</div>
                                <div class="sp-comment-text">${data.comment.text}</div>
                            </div>
                            <div class="sp-comment-actions">
                                <span>${data.comment.time}</span>
                                <button class="sp-reply-btn" onclick="toggleReplyForm(this)">Reply ပြန်ရန်</button>
                            </div>
                        </div>
                    </div>
                    <div class="sp-reply-form">
                        <input type="text" class="sp-comment-input replyInput" placeholder="Reply ပြန်ရန်..." onkeypress="handleReplyKeyPress(event, ${postId}, ${data.comment.id}, this)">
                        <button class="sp-send-btn" style="width: 34px; height: 34px;" onclick="addReply(${postId}, ${data.comment.id}, this)">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"></path></svg>
                        </button>
                    </div>
                    <div class="sp-replies-list"></div>
                `;
                commentsList.prepend(newComment);
                commentCount.innerText = `${data.count} မှတ်ချက်များ`;
                input.value = '';
            }
        })
        .catch(err => console.error(err));
    }

    // Add Reply AJAX
    function addReply(postId, parentId, element) {
        const item = element.closest('.sp-comment-item');
        const input = item.querySelector('.replyInput');
        const text = input.value.trim();

        if (!text) return;

        fetch("{{ route('post.comment') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
            body: JSON.stringify({ post_id: postId, parent_id: parentId, comment: text })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const repliesList = item.querySelector('.sp-replies-list');
                const newReply = document.createElement('div');
                newReply.className = 'sp-comment-main-box';
                newReply.style.marginTop = '8px';
                newReply.innerHTML = `
                    <img src="${data.comment.user_avatar}" class="sp-avatar" style="width:26px; height:26px;" alt="User">
                    <div>
                        <div class="sp-comment-bubble" style="padding: 6px 12px;">
                            <div class="sp-comment-user" style="font-size: 11.5px;">${data.comment.user_name}</div>
                            <div class="sp-comment-text" style="font-size: 12.5px;">${data.comment.text}</div>
                        </div>
                        <div class="sp-comment-actions">
                            <span>${data.comment.time}</span>
                        </div>
                    </div>
                `;
                repliesList.appendChild(newReply);
                input.value = '';
                item.querySelector('.sp-reply-form').classList.remove('active');
            }
        })
        .catch(err => console.error(err));
    }

    // Delete Own Post via AJAX
    function deletePost(postId, button) {
        if (!confirm('ဒီပို့စ်ကို ဖျက်ပစ်ရန် သေချာပါသလား?')) return;

        fetch(`/sellPost/delete/${postId}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Unauthorized or Server Error');
            return res.json();
        })
        .then(data => {
            if (data.success) {
                button.closest('.sp-card').remove();
            } else {
                alert(data.error || 'ပို့စ်ဖျက်၍ မရပါရှင်။');
            }
        })
        .catch(err => {
            console.error(err);
            alert('ပို့စ်ဖျက်ရာတွင် အမှားတစ်ခု ဖြစ်ပေါ်နေပါသည်။');
        });
    }

    // Focus Input Utility
    function focusCommentInput(btn) {
        btn.closest('.sp-card').querySelector('.mainCommentInput').focus();
    }

    // Modal Trigger Placeholder
    function openOfferModal(price) {
        alert('ဈေးဆစ်ရန် စနစ် (Offer Modal) - လက်ရှိ ဈေးနှုန်း: ' + price + ' Ks');
    }
</script>

@endsection
