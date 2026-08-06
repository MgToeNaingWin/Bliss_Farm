@props(['messageId' => null])

<div class="bg-white rounded-full shadow-xl border border-stone-100 px-2 py-1 flex gap-1">
    @foreach(['👍', '❤️', '😂', '😮', '😢', '🙏'] as $emoji)
        <button onclick="toggleReaction({{ $messageId }}, '{{ $emoji }}')"
                class="w-8 h-8 rounded-full hover:bg-stone-100 flex items-center justify-center text-lg transition hover:scale-125">
            {{ $emoji }}
        </button>
    @endforeach
</div>
