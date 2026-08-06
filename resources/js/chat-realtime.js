// ── Chat Real-time Bootstrap ──
// This file initializes Pusher connection for chat real-time features

document.addEventListener('DOMContentLoaded', function () {
    // Only init on chat pages
    if (typeof CHAT_ID === 'undefined') return;

    // Pusher is loaded via CDN in show.blade.php
    // The Alpine.js chatApp component handles all real-time logic

    console.log(`[Chat] Initialized for chat #${CHAT_ID}`);
});
