// ── Chat App ──
// Only runs on chat show page (where window.CHAT_ID is defined)

if (typeof window.CHAT_ID !== 'undefined') {

// ── Helper: JSON fetch ──
function chatFetch(url, options = {}) {
    const defaults = {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': window.CSRF_TOKEN,
            'Accept': 'application/json',
        },
        redirect: 'manual',
    };
    if (options.body && !(options.body instanceof FormData)) {
        defaults.headers['Content-Type'] = 'application/json';
    }
    const config = { ...defaults, ...options, headers: { ...defaults.headers, ...(options.headers || {}) } };
    if (options.body && !(options.body instanceof FormData) && typeof options.body === 'object') {
        config.body = JSON.stringify(options.body);
    }
    return fetch(url, config).then(r => {
        if (r.type === 'opaqueredirect' || r.status === 0) {
            return { error: 'redirect' };
        }
        return r.json();
    }).catch(() => ({ error: 'network' }));
}

document.addEventListener('alpine:init', () => {
    Alpine.data('chatApp', () => ({
        messageText: '',
        replyTo: null,
        editingMessage: null,

        init() {
            this.$nextTick(() => this.scrollToBottom());
        },

        sendMessage() {
            if (!this.messageText.trim()) return;

            const input = document.getElementById('message-input');
            const content = this.messageText.trim();

            if (this.editingMessage) {
                this.editMsg(this.editingMessage.id, content);
                this.editingMessage = null;
            } else if (this.replyTo) {
                this.replyMsg(this.replyTo.id, content);
                this.replyTo = null;
            } else {
                this.sendText(content);
            }

            this.messageText = '';
            input.style.height = 'auto';
        },

        sendText(content) {
            chatFetch(`/chat/${CHAT_ID}/message`, {
                method: 'POST',
                body: { content, type: 'text' }
            }).then(data => {
                if (data && data.message) this.appendMessage(data.message);
            });
        },

        replyMsg(messageId, content) {
            chatFetch(`/chat/message/${messageId}/reply`, {
                method: 'POST',
                body: { content }
            }).then(data => {
                if (data && data.message) this.appendMessage(data.message);
            });
        },

        editMsg(messageId, content) {
            chatFetch(`/chat/message/${messageId}`, {
                method: 'PUT',
                body: { content }
            }).then(data => {
                if (data && data.message) this.updateMessageContent(messageId, content);
            });
        },

        appendMessage(message) {
            if (document.getElementById(`message-${message.id}`)) return;
            const container = this.$refs.messagesContainer;
            if (!container) return;
            container.insertAdjacentHTML('beforeend', this.buildMessageHTML(message));
            this.scrollToBottom();
        },

        buildMessageHTML(message) {
            const isMine = message.sender_id === CURRENT_USER_ID;
            const align = isMine ? 'justify-end' : 'justify-start';
            const bubble = isMine
                ? 'bg-emerald-500 text-white rounded-br-md'
                : 'bg-white border border-stone-100 text-emerald-950 rounded-bl-md shadow-sm';

            let content = '';
            if (message.type === 'text') {
                content = `<p class="text-sm whitespace-pre-wrap break-words">${this.escapeHtml(message.content)}</p>`;
            } else if (message.type === 'image') {
                content = `<img src="/storage/${message.content}" class="rounded-xl max-w-full cursor-pointer hover:opacity-90" onclick="window.open(this.src)">`;
            } else if (message.type === 'video') {
                content = `<video src="/storage/${message.content}" controls class="rounded-xl max-w-full"></video>`;
            } else if (message.type === 'audio') {
                content = `<audio src="/storage/${message.content}" controls class="w-full"></audio>`;
            } else if (message.type === 'file') {
                content = `<a href="/storage/${message.content}" target="_blank" class="flex items-center gap-2 ${isMine ? 'text-white' : 'text-emerald-600'}"><i class="fa-solid fa-file-pdf text-lg"></i><span class="text-xs">${message.metadata?.original_name || 'ဖိုင်'}</span></a>`;
            }

            const time = new Date(message.created_at).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });

            return `
                <div class="flex ${align} group" id="message-${message.id}">
                    <div class="max-w-[75%] relative">
                        <div class="rounded-2xl px-4 py-2.5 ${bubble}">
                            ${content}
                            <div class="flex items-center justify-end gap-1 mt-1">
                                <span class="text-[10px] ${isMine ? 'text-emerald-100' : 'text-stone-400'}">${time}</span>
                                ${isMine ? '<i class="fa-solid fa-check text-emerald-200 text-[10px]"></i>' : ''}
                            </div>
                        </div>
                    </div>
                </div>`;
        },

        updateMessageContent(messageId, content) {
            const el = document.getElementById(`message-${messageId}`);
            if (el) {
                const p = el.querySelector('p');
                if (p) p.textContent = content;
            }
        },

        scrollToBottom() {
            const container = this.$refs.messagesContainer;
            if (container) container.scrollTop = container.scrollHeight;
        },

        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    }));
});

// ── Global Functions ──

function replyToMessage(id, senderName, content) {
    const el = document.querySelector('[x-data]');
    if (el) {
        const app = Alpine.$data(el);
        if (app) {
            app.replyTo = { id, sender_name: senderName, content };
            app.editingMessage = null;
        }
    }
    document.getElementById('message-input')?.focus();
}

function editMessage(id, content) {
    const el = document.querySelector('[x-data]');
    if (el) {
        const app = Alpine.$data(el);
        if (app) {
            app.editingMessage = { id, content };
            app.replyTo = null;
        }
    }
    document.getElementById('message-input')?.focus();
}

function deleteMessage(id) {
    if (!confirm('ဖျက်မည်ဖြစ်ပါက ပြန်မရနိုင်ပါ။ ဖျက်မည်လား?')) return;
    chatFetch(`/chat/message/${id}`, { method: 'DELETE' }).then(data => {
        if (data && data.success) {
            const el = document.getElementById(`message-${id}`);
            if (el) {
                const bubble = el.querySelector('.rounded-2xl');
                if (bubble) bubble.innerHTML = '<p class="text-xs italic text-stone-400"><i class="fa-solid fa-ban mr-1"></i>ဖျက်လိုက်ပြီ</p>';
            }
        }
    });
}

function copyMessage(content) { navigator.clipboard?.writeText(content); }

function toggleReaction(messageId, emoji) {
    chatFetch(`/chat/message/${messageId}/react`, { method: 'POST', body: { emoji } });
}

function toggleMute() {
    chatFetch(`/chat/${CHAT_ID}/mute`, { method: 'PUT' }).then(data => {
        if (data && !data.error) alert(data.is_muted ? 'အသံပိတ်လိုက်ပြီ' : 'အသံဖွင့်လိုက်ပြီ');
    });
}

function togglePin() {
    chatFetch(`/chat/${CHAT_ID}/pin`, { method: 'PUT' }).then(data => {
        if (data && !data.error) alert(data.is_pinned ? 'Pin ထားလိုက်ပြီ' : 'Pin ဖြုတ်လိုက်ပြီ');
    });
}

function sendFile(input, type) {
    if (!input.files || !input.files[0]) return;
    const formData = new FormData();
    formData.append('file', input.files[0]);
    formData.append('type', type);
    fetch(`/chat/${CHAT_ID}/message`, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
        body: formData,
        redirect: 'manual'
    }).then(r => r.json()).then(data => {
        if (data && data.message) {
            const el = document.querySelector('[x-data]');
            if (el) { const app = Alpine.$data(el); if (app) app.appendMessage(data.message); }
        }
        input.value = '';
    }).catch(() => {});
}

function forwardMessage(id) {
    const chatIds = prompt('ပို့မည့် chat ID များထည့်ပါ (comma separated):');
    if (!chatIds) return;
    chatFetch(`/chat/message/${id}/forward`, { method: 'POST', body: { chat_ids: chatIds.split(',').map(Number) } })
        .then(data => { if (data && data.success) alert('ပို့ပြီးပါပြီ'); });
}

} // end if
