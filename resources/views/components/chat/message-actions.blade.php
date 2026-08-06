@props(['messageId' => null, 'isMine' => false, 'isText' => true, 'isDeleted' => false])

<div class="bg-white rounded-xl shadow-xl border border-stone-100 py-2 w-44 z-30">
    <button onclick="replyToMessage({{ $messageId }})"
            class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2">
        <i class="fa-solid fa-reply text-stone-400"></i>ပြန်ဖြေရန်
    </button>
    <button onclick="forwardMessage({{ $messageId }})"
            class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2">
        <i class="fa-solid fa-share text-stone-400"></i>ပို့ရန်
    </button>
    <button onclick="copyMessage('')"
            class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2">
        <i class="fa-solid fa-copy text-stone-400"></i>ကူးယူရန်
    </button>
    @if($isMine && $isText && !$isDeleted)
        <button onclick="editMessage({{ $messageId }})"
                class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2">
            <i class="fa-solid fa-pen text-stone-400"></i>ပြင်ဆင်ရန်
        </button>
        <button onclick="deleteMessage({{ $messageId }})"
                class="w-full text-left px-4 py-2 text-sm hover:bg-red-50 text-red-500 flex items-center gap-2">
            <i class="fa-solid fa-trash"></i>ဖျက်ရန်
        </button>
    @endif
</div>
