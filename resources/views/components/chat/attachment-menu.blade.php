<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="w-10 h-10 rounded-full hover:bg-stone-100 flex items-center justify-center text-stone-500 transition shrink-0">
        <i class="fa-solid fa-plus"></i>
    </button>

    <div x-show="open" @click.outside="open = false"
         x-transition
         class="absolute bottom-full left-0 mb-2 bg-white rounded-xl shadow-xl border border-stone-100 py-2 w-44 z-50">
        <label class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-image text-emerald-500"></i>ဓာတ်ပုံ
            <input type="file" accept="image/*" class="hidden" onchange="sendFile(this, 'image')">
        </label>
        <label class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-video text-blue-500"></i>ဗီဒီယို
            <input type="file" accept="video/*" class="hidden" onchange="sendFile(this, 'video')">
        </label>
        <label class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-file text-amber-500"></i>ဖိုင်
            <input type="file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="hidden" onchange="sendFile(this, 'file')">
        </label>
        <label class="w-full text-left px-4 py-2 text-sm hover:bg-stone-50 flex items-center gap-2 cursor-pointer">
            <i class="fa-solid fa-microphone text-red-500"></i>အသံ
            <input type="file" accept="audio/*" class="hidden" onchange="sendFile(this, 'audio')">
        </label>
    </div>
</div>
