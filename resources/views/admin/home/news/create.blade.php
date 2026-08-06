@extends('admin.layouts.master')
@section('content')
    <div class="bg-gray-100 min-h-screen pb-10">

        <!-- HEADER (Responsive & Height Auto) -->
        <div class="my-3 px-4 sm:px-8 py-3 flex flex-col sm:flex-row items-center justify-between bg-green-500 gap-3 rounded-lg mx-3">
            <h1 class="font-bold text-xl sm:text-2xl text-white inline-flex items-center">သတင်းများ စီမံရန်</h1>

            <!-- Manage All Button -->
            <a href="{{ route('newsManageAll') }}"
               class="bg-white text-green-600 px-4 py-1.5 rounded-md text-xs font-bold hover:bg-green-50 transition duration-200 self-stretch sm:self-auto text-center shadow-sm">
                သတင်းအားလုံး စီမံရန်
            </a>
        </div>

        <!-- LAYOUT -->
        <div class="flex flex-col mx-3 mt-6 lg:flex-row gap-4">

            <!-- ဘယ်ဘက်ခြမ်း - သတင်းတင်ရန် Form (W-full to LG:W-2/3) -->
            <div class="w-full lg:w-2/3">
                <form class="w-full bg-white shadow-md p-5 sm:p-6 rounded-xl border border-gray-100" action="{{ route('newsCreate') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-5">

                        <!-- News Title -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">သတင်းခေါင်းစဉ် *</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="text-gray-700 text-sm rounded-lg px-3 py-2.5 border-2 w-full border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200"
                                placeholder="သတင်းခေါင်းစဉ် ရေးထည့်ပါ..." required>
                            @error('title')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Writer Input Field -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">ရေးသားသူအမည် *</label>
                            <input type="text" name="writer" value="{{ old('writer') }}"
                                class="text-gray-700 text-sm rounded-lg px-3 py-2.5 border-2 w-full border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200"
                                placeholder="ရေးသားသူအမည် ရေးထည့်ပါ..." required>
                            @error('writer')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">သတင်းအကြောင်းအရာ ရှင်းလင်းချက်</label>
                            <textarea rows="5" name="description"
                                class="text-gray-700 text-sm rounded-lg px-3 py-2.5 border-2 w-full border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200"
                                placeholder="သတင်းအသေးစိတ် ရေးသားရန်...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- UPLOAD IMAGE WITH PREVIEW AREA -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">သတင်းဓာတ်ပုံတင်ရန်</label>
                            <label class="mx-auto cursor-pointer flex w-full max-w-lg flex-col items-center justify-center rounded-xl border-2 border-dashed border-green-400 bg-white p-6 text-center"
                                for="dropzone-file">

                                <div id="preview-container" class="flex flex-col items-center justify-center">
                                    <!-- Image Icon -->
                                    <svg id="upload-icon" class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <!-- Live Preview Image Box -->
                                    <img id="image-preview" class="hidden w-32 h-32 object-cover rounded-lg mb-3 border border-gray-200 shadow-sm" src="#" alt="Preview">

                                    <!-- Texts -->
                                    <h2 id="upload-text" class="text-sm font-medium text-gray-700">ဓာတ်ပုံရွေးချယ်ရန်</h2>
                                    <p id="file-name-text" class="text-xs text-green-600 font-semibold mt-1 max-w-xs truncate"></p>
                                </div>

                                <input name="newsPhoto" id="dropzone-file" type="file" class="hidden" accept="image/*" />
                            </label>
                            @error('newsPhoto')
                                <p class="text-red-500 text-xs italic mt-1 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full bg-green-500 text-white font-bold rounded-lg py-3 hover:bg-green-600 transition duration-200 shadow-sm">
                                သတင်းတင်မည်
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ညာဘက်ခြမ်း - READ / SHOW NEWS TABLE (W-full to LG:W-1/3) -->
            <div class="w-full lg:w-1/3 bg-white shadow-md text-lg rounded-xl border border-gray-100 self-start p-4">
                <h3 class="text-base font-bold text-gray-800 mb-3 pb-2 border-b border-gray-100">နောက်ဆုံးတင်ထားသော သတင်းများ</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <tbody>
                            @if ($news->count() > 0)
                                @foreach ($news as $item)
                                    <tr class="relative text-sm py-3 border-b border-gray-100 block last:border-b-0">
                                        <td class="py-2 block w-full">
                                            <!-- သတင်းပုံလေး ထည့်ပြထားခြင်း -->
                                            @if ($item->{'news-img'})
                                                <img src="{{ asset('newsImage/' . $item->{'news-img'}) }}"
                                                    class="w-16 h-16 object-cover rounded-lg mb-2 shadow-sm">
                                            @endif

                                            <div class="leading-5 text-gray-800 font-bold mb-1 break-words">{{ $item->title }}</div>

                                            <!-- Writer ပြသခြင်း -->
                                            <div class="text-xs text-gray-500 mb-1 break-words">ရေးသားသူ - {{ $item->writer }}</div>

                                            <!-- Description -->
                                            <div class="leading-relaxed text-gray-600 text-xs mb-3 break-words">
                                                <p>{{ \Illuminate\Support\Str::limit($item->description ?? '', 40, '...') }}</p>
                                            </div>

                                            <!-- Date and Buttons -->
                                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 text-xs text-gray-500">
                                                <div class="font-medium text-gray-400">
                                                    {{ $item->created_at ? $item->created_at->format('d / m / Y') : 'ရက်စွဲမရှိပါ' }}
                                                </div>
                                                <div class="flex space-x-2 self-end sm:self-auto">
                                                    <!-- EDIT BUTTON -->
                                                    <a href="{{ route('newsEditPage', $item->id) }}"
                                                        class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition text-xs font-semibold">ပြင်ဆင်ရန်</a>
                                                    <!-- DELETE BUTTON -->
                                                    <button type="button" data-url="{{ route('newsDelete', $item->id) }}"
                                                        class="delete-btn bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition focus:outline-none text-xs font-semibold">
                                                        ဖျက်မည်
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center text-sm py-8 text-gray-500">သတင်းများ မရှိသေးပါ။</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- MANAGE ALL BUTTON -->
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="{{ route('newsManageAll') }}"
                           class="block w-full text-center bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-2.5 px-4 rounded-md transition duration-200 shadow-sm">
                             သတင်းအားလုံးကို စီမံရန် →
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==================== IMAGE PREVIEW & FILE NAME SCRIPT ====================
            const fileInput = document.getElementById('dropzone-file');
            const imagePreview = document.getElementById('image-preview');
            const uploadIcon = document.getElementById('upload-icon');
            const uploadText = document.getElementById('upload-text');
            const fileNameText = document.getElementById('file-name-text');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        uploadIcon.classList.add('hidden');

                        // စာသားများကို မြန်မာဘာသာသို့ ပြောင်းလဲမည်
                        uploadText.innerText = "ဓာတ်ပုံပြောင်းရန်";
                        fileNameText.innerText = "ရွေးချယ်ထားသောဖိုင် - " + file.name;
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = "#";
                    imagePreview.classList.add('hidden');
                    uploadIcon.classList.remove('hidden');
                    uploadText.innerText = "ဓာတ်ပုံရွေးချယ်ရန်";
                    fileNameText.innerText = "";
                }
            });

            // ==================== SWEETALERT DELETE BUTTON SCRIPT ====================
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
