@extends('admin.layouts.master')
@section('content')
<div class="bg-gray-100 min-h-screen pb-10">

    <!-- HEADER -->
    <div class="header my-3 h-auto py-3 px-6 sm:px-10 flex flex-col sm:flex-row items-center justify-between bg-green-500 shadow-sm gap-3 rounded-lg mx-3">
        <h1 class="font-bold text-xl sm:text-2xl text-white inline-flex items-center text-center sm:text-left">
            ရောဂါများ စီမံခန့်ခွဲမှု (စုစုပေါင်း: {{ $diseases->count() > 0 ? $diseases->total() : '၄ (နမူနာ)' }} ခု)
        </h1>
        <a href="{{ route('diseaseCreatePage') }}"
            class="bg-white text-green-600 px-4 py-1.5 rounded-lg text-xs sm:text-sm font-bold hover:bg-green-50 transition duration-200 self-stretch sm:self-auto text-center shadow-sm">
            + ရောဂါအချက်အလက်အသစ်ထည့်မည်
        </a>
    </div>

    <!-- CARDS GRID CONTAINER -->
    <div class="mx-3 sm:mx-6 mt-6">
        @if(session('success'))
            <div class="mb-4 bg-green-500 border-l-4 border-green-700 text-white p-4 rounded-r-lg shadow-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if ($diseases->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($diseases as $item)
                    <!-- Card Container -->
                    <div class="bg-white p-4 rounded-2xl shadow-md border border-gray-100 flex flex-col justify-between hover:shadow-lg hover:border-green-500 transition duration-300 min-h-[380px]">

                        <!-- Top Image Section -->
                        <div class="relative h-44 w-full bg-gray-50 rounded-xl overflow-hidden shadow-inner flex-shrink-0">
                            @if ($item->disease_img)
                                <img src="{{ asset('diseaseImage/' . $item->disease_img) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-semibold bg-gray-100 px-4 text-center">
                                    [ ဓာတ်ပုံမရှိပါ ]
                                </div>
                            @endif
                            <span class="absolute top-2.5 right-2.5 bg-green-500 text-white text-[10px] px-2.5 py-1 rounded-full font-bold shadow-sm">
                                {{ $item->animalType->type_title ?? 'အမျိုးအစားမသိရ' }}
                            </span>
                        </div>

                        <!-- Card Content Section -->
                        <div class="pt-4 flex-1 flex flex-col justify-between min-w-0">
                            <div class="space-y-2">
                                <!-- Title -->
                                <h2 class="text-sm sm:text-base font-bold text-gray-800 line-clamp-2 leading-snug break-words">
                                    <a href="{{ route('diseaseDetail', $item->id) }}" class="hover:text-green-500 transition">
                                        {{ $item->disease_title }}
                                    </a>
                                </h2>

                                <!-- Description -->
                                <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 break-words">
                                    {{ str($item->disease_desc ?? '')->words(18, '...') }}
                                </p>
                            </div>

                            <!-- Bottom Action Section -->
                            <div class="mt-4 pt-3 border-t border-gray-100 flex flex-col gap-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] text-gray-400 font-bold">ရက်စွဲ</span>
                                    <span class="text-[11px] text-gray-600 font-semibold">
                                        {{ $item->created_at ? $item->created_at->format('d/m/Y') : 'ရက်စွဲမရှိပါ' }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-3 gap-1.5">
                                    <!-- DETAIL BUTTON -->
                                    <a href="{{ route('diseaseDetail', $item->id) }}"
                                       class="bg-gray-100 text-gray-700 hover:bg-gray-200 text-[11px] py-2 rounded-lg font-bold transition text-center"
                                       title="အသေးစိတ်ကြည့်ရှုရန်">
                                       အသေးစိတ်
                                    </a>
                                    <!-- EDIT BUTTON -->
                                    <a href="{{ route('diseaseEditPage', $item->id) }}"
                                       class="bg-blue-50 text-blue-600 hover:bg-blue-100 text-[11px] py-2 rounded-lg font-bold transition text-center"
                                       title="ပြင်ဆင်ရန်">
                                       ပြင်ဆင်ရန်
                                    </a>
                                    <!-- DELETE BUTTON -->
                                    <button type="button" data-url="{{ route('diseaseDelete', $item->id) }}"
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

            <div class="mt-8">
                {{ $diseases->links() }}
            </div>
        @else
            <!-- Sample Data (If DB is empty) -->
            <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg shadow-sm mx-3">
                <p class="text-sm text-yellow-700 font-medium">
                    မှတ်ချက်။ ။ လက်ရှိ စနစ်ထဲတွင် ရောဂါအချက်အလက်များ မရှိသေးသောကြောင့် စမ်းသပ်ကြည့်ရှုနိုင်ရန် <strong>နမူနာများ</strong> ကို ပြသထားခြင်း ဖြစ်ပါသည်။
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mx-3">
                <!-- Sample 1 -->
                <div class="bg-white p-4 rounded-2xl shadow-md border border-gray-100 flex flex-col justify-between hover:shadow-lg transition min-h-[380px]">
                    <div class="relative h-44 w-full bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-orange-500 font-bold text-xs">[ ခွာနာလျှာနာရောဂါ ပုံရိပ် ]</span>
                        <span class="absolute top-2.5 right-2.5 bg-yellow-500 text-white text-[10px] px-2.5 py-1 rounded-full font-bold">နမူနာ - နွား</span>
                    </div>
                    <div class="pt-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h2 class="text-sm sm:text-base font-bold text-gray-800">ခွာနာလျှာနာ ရောဂါ (FMD)</h2>
                            <p class="text-xs text-gray-500 line-clamp-3">ခွာနာလျှာနာရောဂါသည် ကူးစက်မြန်ပြီး နွား၊ ကျွဲ၊ သိုး၊ ဆိတ် စသည့် ကွဲပြားသော တိရစ္ဆာန်များတွင် အဓိကဖြစ်ပွားတတ်သည်။</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex flex-col gap-3 opacity-80">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-gray-400 font-bold">ရက်စွဲ</span>
                                <span class="text-[11px] text-gray-600 font-semibold">၁၇/၀၇/၂၀၂၆</span>
                            </div>
                            <div class="grid grid-cols-1">
                                <span class="bg-gray-100 text-[11px] py-2 rounded-lg font-bold text-gray-600 text-center cursor-not-allowed">နမူနာကြည့်ရှုမှု</span>
                            </div>
                        </div>
                    </div>
                </div>
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
                    text: "ဤရောဂါအချက်အလက်ကို ဖျက်လိုက်ပါက ပြန်လည်ရယူနိုင်တော့မည် မဟုတ်ပါ!",
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
