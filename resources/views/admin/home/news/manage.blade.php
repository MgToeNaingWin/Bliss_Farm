@extends('admin.layouts.master')
@section('content')
<div class="bg-gray-100 min-h-screen pb-10">

    <!-- HEADER (Responsive & Height Auto) -->
    <div class="my-3 px-4 sm:px-8 py-3 flex flex-col sm:flex-row items-center justify-between bg-green-500 gap-3 rounded-lg mx-3 shadow-sm">
        <h1 class="font-bold text-xl sm:text-2xl text-white inline-flex items-center text-center sm:text-left">
            သတင်းအားလုံး စီမံရန် (စုစုပေါင်း: {{ $news->total() }})
        </h1>
        <a href="{{ route('newsCreatePage') }}"
            class="bg-white text-green-600 px-4 py-1.5 rounded-lg text-xs sm:text-sm font-bold hover:bg-green-50 transition duration-200 self-stretch sm:self-auto text-center shadow-sm">
            + သတင်းအသစ်ထည့်မည်
        </a>
    </div>

    <!-- CARDS GRID CONTAINER -->
    <div class="mx-3 sm:mx-6 mt-6">
        @if ($news->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($news as $item)
                    <!-- Card Container (Adjusted like disease card) -->
                    <div class="bg-white p-4 rounded-2xl shadow-md border border-gray-100 flex flex-col justify-between hover:shadow-lg hover:border-green-500 transition duration-300 min-h-[380px]">

                        <!-- Top Image Section -->
                        <div class="relative h-44 w-full bg-gray-50 rounded-xl overflow-hidden shadow-inner flex-shrink-0">
                            @if ($item->{'news-img'})
                                <img src="{{ asset('newsImage/' . $item->{'news-img'}) }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-semibold bg-gray-100 px-4 text-center">
                                    [ ဓာတ်ပုံမရှိပါ ]
                                </div>
                            @endif
                            <span class="absolute top-2.5 right-2.5 bg-green-500 text-white text-[10px] px-2.5 py-1 rounded-full font-bold shadow-sm">
                                လွှင့်တင်ပြီး
                            </span>
                        </div>

                        <!-- Card Content Section -->
                        <div class="pt-4 flex-1 flex flex-col justify-between min-w-0">
                            <div class="space-y-2">
                                <!-- Writer Tag -->
                                <span class="text-[10.5px] font-bold text-green-600 uppercase tracking-wider block break-words">
                                    ရေးသားသူ - {{ $item->writer }}
                                </span>

                                <!-- Title -->
                                <h2 class="text-sm sm:text-base font-bold text-gray-800 line-clamp-2 leading-snug break-words">
                                    <a href="{{ route('newsDetail', $item->id) }}" class="hover:text-green-500 transition">
                                        {{ $item->title }}
                                    </a>
                                </h2>

                                <!-- Description -->
                                <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 break-words whitespace-normal">
                                    {{ str($item->description ?? '')->words(20, '...') }}
                                </p>
                            </div>

                            <!-- Bottom Action Section (Adjusted to match disease style) -->
                            <div class="mt-4 pt-3 border-t border-gray-100 flex flex-col gap-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] text-gray-400 font-bold">ရက်စွဲ</span>
                                    <span class="text-[11px] text-gray-600 font-semibold">
                                        {{ $item->created_at ? $item->created_at->format('d/m/Y') : 'ရက်စွဲမရှိပါ' }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-3 gap-1.5">
                                    <!-- DETAIL LINK BUTTON -->
                                    <a href="{{ route('newsDetail', $item->id) }}"
                                       class="bg-gray-100 text-gray-700 hover:bg-gray-200 text-[11px] py-2 rounded-lg font-bold transition text-center"
                                       title="အသေးစိတ်ကြည့်ရှုရန်">
                                       အသေးစိတ်
                                    </a>

                                    <!-- EDIT BUTTON -->
                                    <a href="{{ route('newsEditPage', $item->id) }}"
                                       class="bg-blue-50 text-blue-600 hover:bg-blue-100 text-[11px] py-2 rounded-lg font-bold transition text-center"
                                       title="ပြင်ဆင်ရန်">
                                       ပြင်ဆင်ရန်
                                    </a>

                                    <!-- DELETE BUTTON -->
                                    <button type="button" data-url="{{ route('newsDelete', $item->id) }}"
                                       class="delete-btn bg-red-50 text-red-600 hover:bg-red-100 text-[11px] py-2 rounded-lg font-bold transition focus:outline-none text-center"
                                       title="ဖျက်သိမ်းရန်">
                                       ဖျက်မည်
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Link buttons -->
            <div class="mt-8">
                {{ $news->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-md p-12 text-center text-gray-500 border border-gray-100 mx-3">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-950 mb-1">သတင်းများ မတွေ့ရှိရသေးပါ</h3>
                <p class="text-sm text-gray-500">သတင်းအသစ်များ တင်သွင်းရန် ညာဘက်အပေါ်ရှိ ခလုတ်ကို နှိပ်ပါ။</p>
            </div>
        @endif
    </div>

</div>

<!-- SweetAlert2 Delete Confirmation -->
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
