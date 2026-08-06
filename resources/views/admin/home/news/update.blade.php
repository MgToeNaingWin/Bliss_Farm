@extends('admin.layouts.master')
@section('content')
    <div class="bg-gray-100 min-h-screen pb-10">

        <!-- HEADER (Responsive & Height Auto) -->
        <div class="my-3 px-4 sm:px-8 py-3 flex flex-col sm:flex-row items-center justify-between bg-green-500 gap-3 rounded-lg mx-3 shadow-sm">
            <h1 class="font-bold text-xl sm:text-2xl text-white inline-flex items-center">သတင်းပြင်ဆင်ရန်</h1>
            <a href="{{ route('adminHome') }}"
               class="bg-white text-green-600 px-4 py-1.5 rounded-md text-xs sm:text-sm font-bold hover:bg-green-50 transition duration-200 self-stretch sm:self-auto text-center shadow-sm">
               နောက်သို့
            </a>
        </div>

        <!-- LAYOUT - Form ကို အလယ်တည့်တည့်တွင် သပ်ရပ်စွာ ပြသထားပါသည် -->
        <div class="flex justify-center mx-3 sm:mx-6 mt-6">
            <div class="w-full max-w-3xl">
                <form class="w-full bg-white shadow-md p-5 sm:p-8 rounded-2xl border border-gray-100" action="{{ route('newsUpdate', $newsItem->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap -mx-3 mb-6">

                        <!-- News Title Box -->
                        <div class="w-full px-3 mb-6">
                            <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2">သတင်းခေါင်းစဉ်</label>
                            <input type="text" name="title" value="{{ old('title', $newsItem->title) }}" class="text-gray-700 text-sm rounded-xl px-4 py-3 border-2 w-full border-neutral-300 focus:border-green-500 focus:outline-none transition">
                            @error('title')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Writer Name Box -->
                        <div class="w-full px-3 mb-6">
                            <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2">ရေးသားသူအမည်</label>
                            <input type="text" name="writer" value="{{ old('writer', $newsItem->writer) }}" class="text-gray-700 text-sm rounded-xl px-4 py-3 border-2 w-full border-neutral-300 focus:border-green-500 focus:outline-none transition">
                            @error('writer')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- News Description Box -->
                        <div class="w-full px-3 mb-6">
                            <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2">သတင်းအကြောင်းအရာ</label>
                            <textarea rows="6" name="description" class="text-gray-700 text-sm rounded-xl px-4 py-3 border-2 w-full border-neutral-300 focus:border-green-500 focus:outline-none transition leading-relaxed">{{ old('description', $newsItem->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Upload Box with Live Preview & Current Image toggle -->
                        <div class="w-full px-3 mb-6">
                            <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2">သတင်းဓာတ်ပုံ</label>

                            <!-- Live Preview Area -->
                            <div class="flex flex-col items-center justify-center mb-4">
                                @if($newsItem->{'news-img'})
                                    <!-- လက်ရှိ Database ထဲက ပုံကို အရင်ပြထားမည် -->
                                    <img id="image-preview" src="{{ asset('newsImage/'.$newsItem->{'news-img'}) }}" class="w-40 h-40 object-cover rounded-xl shadow-md border border-gray-200 mb-2">
                                    <span id="image-status-text" class="text-xs text-gray-500 italic mb-2">လက်ရှိအသုံးပြုထားသော ပုံဟောင်း</span>
                                @else
                                    <!-- လက်ရှိတွင် ပုံမရှိပါက Default No Image ပုံစံပြမည် -->
                                    <img id="image-preview" src="#" class="hidden w-40 h-40 object-cover rounded-xl shadow-md border border-gray-200 mb-2">
                                    <div id="no-image-text" class="text-xs text-gray-400 mb-2 italic">လက်ရှိတွင် ပုံမရှိသေးပါ။</div>
                                @endif
                                <p id="file-name-text" class="text-xs text-green-600 font-semibold mt-1 max-w-xs truncate"></p>
                            </div>

                            <!-- Upload Box -->
                            <label class="mx-auto cursor-pointer flex w-full max-w-lg flex-col items-center justify-center rounded-xl border-2 border-dashed border-green-400 bg-white p-4 text-center hover:bg-green-50/50 transition" for="dropzone-file">
                                <span id="upload-instruction-text" class="text-gray-600 text-sm font-medium">ပုံအသစ်လဲလိုပါက ဤနေရာတွင် ရွေးချယ်ပါ</span>
                                <input name="newsPhoto" id="dropzone-file" type="file" class="hidden" accept="image/*" />
                            </label>
                            @error('newsPhoto')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Update Button -->
                        <div class="w-full px-3 mt-4">
                            <button type="submit" class="w-full bg-green-500 text-white font-bold rounded-xl py-3.5 hover:bg-green-600 transition shadow-md">
                                ပြင်ဆင်ချက်များ သိမ်းဆည်းမည်
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Live Preview JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==================== IMAGE PREVIEW & FILE NAME SCRIPT ====================
            const fileInput = document.getElementById('dropzone-file');
            const imagePreview = document.getElementById('image-preview');
            const fileNameText = document.getElementById('file-name-text');
            const imageStatusText = document.getElementById('image-status-text');
            const noImageText = document.getElementById('no-image-text');
            const uploadInstructionText = document.getElementById('upload-instruction-text');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden'); // hidden ဖြစ်နေရင် ဖယ်ပေးမည်

                        // စာသားအခြေအနေများကို Live ပြောင်းလဲမည်
                        if (imageStatusText) {
                            imageStatusText.innerText = "ရွေးချယ်ထားသော ပုံအသစ် Preview";
                            imageStatusText.classList.remove('text-gray-500');
                            imageStatusText.classList.add('text-green-600', 'font-semibold');
                        }
                        if (noImageText) {
                            noImageText.classList.add('hidden');
                        }

                        uploadInstructionText.innerText = "ပုံအသစ်ကို ပြန်လဲရန် နှိပ်ပါ";
                        fileNameText.innerText = "ရွေးချယ်ထားသောဖိုင် - " + file.name;
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
