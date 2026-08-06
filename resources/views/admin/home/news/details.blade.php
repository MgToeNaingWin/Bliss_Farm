@extends('admin.layouts.master')
@section('content')
<div class="bg-gray-100 min-h-screen pb-10">

    <!-- HEADER (Responsive design with auto-height) -->
    <div class="my-3 px-4 sm:px-8 py-3 flex flex-col sm:flex-row items-center justify-between bg-green-500 gap-3 rounded-lg mx-3 shadow-sm">
        <h1 class="font-bold text-xl sm:text-2xl text-white inline-flex items-center">သတင်းအသေးစိတ်</h1>
        <a href="{{ url('/admin/news/manage-all') }}"
           class="bg-white text-green-600 px-4 py-1.5 rounded-md text-xs font-bold hover:bg-green-50 transition duration-200 self-stretch sm:self-auto text-center shadow-sm">
           ← သတင်းအားလုံးစီမံရန်သို့ ပြန်သွားမည်
        </a>
    </div>

    <!-- DETAIL CARD CONTAINER -->
    <div class="max-w-4xl mx-auto mt-6 px-3 sm:px-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 flex flex-col">

            <!-- Large Image Banner Section -->
            <div class="relative w-full bg-gray-950 flex items-center justify-center max-h-[450px] overflow-hidden">
                @if ($newsItem->{'news-img'})
                    <img src="{{ asset('newsImage/' . $newsItem->{'news-img'}) }}"
                         class="w-full h-auto object-contain max-h-[450px]">
                @else
                    <div class="w-full h-64 flex flex-col items-center justify-center text-gray-400 bg-gray-900 px-4 text-center">
                        <svg class="h-16 w-16 mb-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-semibold">ဤသတင်းအတွက် တင်ထားသော ဓာတ်ပုံမရှိပါ</span>
                    </div>
                @endif

                <span class="absolute top-4 right-4 bg-green-500 text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-md">
                    လွှင့်တင်ပြီး
                </span>
            </div>

            <!-- Content Details Section -->
            <div class="p-5 sm:p-8 min-w-0 flex-1 flex flex-col justify-between">
                <div>
                    <!-- Meta Info (Writer & Date) -->
                    <div class="flex flex-col sm:flex-row sm:items-center text-xs sm:text-sm text-gray-500 gap-2 sm:gap-4 mb-5 pb-3 border-b border-gray-100">
                        <div class="flex items-center">
                            <span class="font-bold text-green-600 tracking-wide break-all">
                                ရေးသားသူ - {{ $newsItem->writer }}
                            </span>
                        </div>
                        <div class="hidden sm:inline-block text-gray-300">|</div>
                        <div class="flex items-center">
                            <span>တင်သည့်ရက်စွဲ - {{ $newsItem->created_at ? $newsItem->created_at->format('d / m / Y (h:i A)') : 'ရက်စွဲမရှိပါ' }}</span>
                        </div>
                    </div>

                    <!-- Full Title -->
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-900 leading-snug mb-6 break-words whitespace-normal">
                        {{ $newsItem->title }}
                    </h2>

                    <!-- Full Description -->
                    <div class="text-gray-700 text-sm sm:text-base leading-relaxed break-words whitespace-pre-line bg-gray-50 p-4 sm:p-5 rounded-xl border border-gray-100">
                        {{ $newsItem->description }}
                    </div>
                </div>

                <!-- Action Footer (Mobile responsive buttons stack on very small screens) -->
                <div class="mt-8 pt-5 border-t border-gray-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                    <a href="{{ route('newsEditPage', $newsItem->id) }}"
                       class="bg-blue-500 text-white hover:bg-blue-600 text-xs sm:text-sm px-5 py-2.5 rounded-lg font-bold shadow-sm transition duration-150 text-center">
                       သတင်းပြင်ဆင်ရန်
                    </a>
                    <button type="button" data-url="{{ route('newsDelete', $newsItem->id) }}"
                       class="delete-btn bg-red-500 text-white hover:bg-red-600 text-xs sm:text-sm px-5 py-2.5 rounded-lg font-bold shadow-sm transition duration-150 focus:outline-none">
                       သတင်းဖျက်မည်
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 Delete Confirmation (မူလအတိုင်း အလုပ်လုပ်စေရန်) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const deleteUrl = this.getAttribute('data-url');
                Swal.fire({
                    title: 'သေချာပါသလား?',
                    text: "ဤသတင်းကို ဖျက်လိုက်ပါက ပြန်လည်ရယူနိုင်တော့မည်မဟုတ်ပါ!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48', // Red 600
                    cancelButtonColor: '#4b5563',  // Gray 600
                    confirmButtonText: 'ဟုတ်ကဲ့၊ ဖျက်မည်!',
                    cancelButtonText: 'မဖျက်တော့ပါ'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    });
</script>
@endsection
