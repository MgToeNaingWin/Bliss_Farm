@extends('user.layouts.master')

@section('bdy')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-6">

    <!-- Header Section -->
    <div class="mb-6 text-center sm:text-left">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-emerald-950 flex items-center justify-center sm:justify-start gap-2">
            <i class="fa-solid fa-square-plus text-amber-500"></i>
            <span>အရောင်းအဝယ် ပို့စ်အသစ်တင်ရန်</span>
        </h1>
        <p class="text-xs sm:text-sm text-gray-600 mt-1">
            သင့်၏ မွေးမြူရေး၊ စိုက်ပျိုးရေး ထွက်ကုန်များနှင့် ပစ္စည်းများကို အလွယ်တကူ ရောင်းချလိုက်ပါ
        </p>
    </div>

    <!-- Main Card Container -->
    <div class="bg-white rounded-2xl border border-emerald-900/10 shadow-xl p-5 sm:p-8">

        <form action="{{ route('createPost') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. Post Title (ခေါင်းစဉ်) -->
            <div>
                <label for="title" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
                    ပို့စ် ခေါင်းစဉ် <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title') }}"
                           placeholder="ဥပမာ - ထိုင်းဝက်မျိုးကောင်း ဝက်ဝယ်ရန် / စိုက်ပျိုးရေးမြေဩဇာ ရောင်းရန်"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm outline-none transition duration-200 @error('title') border-red-500 @enderror"
                           >
                </div>
                @error('title')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Category & Price Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <!-- Category Select (အမျိုးအစား) -->
                <div>
                    <label for="category" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
                        အမျိုးအစား <span class="text-red-500">*</span>
                    </label>
                    <select name="category"
                            id="category"
                            onchange="toggleAnimalType(this.value)"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm outline-none transition duration-200 bg-white @error('category') border-red-500 @enderror"
                            >
                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>အမျိုးအစား ရွေးချယ်ပါ</option>
                        <option value="livestock" {{ old('category') == 'livestock' ? 'selected' : '' }}>တိရစ္ဆာန် မွေးမြူရေး (Livestock)</option>
                        <option value="crops" {{ old('category') == 'crops' ? 'selected' : '' }}>စိုက်ပျိုးရေး ထွက်ကုန် (Crops)</option>
                        <option value="equipment" {{ old('category') == 'equipment' ? 'selected' : '' }}>စိုက်ပျိုး/မွေးမြူရေး သုံးကိရိယာ (Equipment)</option>
                        <option value="feed" {{ old('category') == 'feed' ? 'selected' : '' }}>အစာနှင့် ဆေးဝါးများ (Feed & Fertilizer)</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>အခြား (Others)</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price (ဈေးနှုန်း) -->
                <div>
                    <label for="price" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
                        ဈေးနှုန်း (ကျပ်) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number"
                               name="price"
                               id="price"
                               value="{{ old('price') }}"
                               placeholder="ဥပမာ - 150000"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm outline-none transition duration-200 @error('price') border-red-500 @enderror"
                               >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-gray-400">
                            ကျပ်
                        </span>
                    </div>
                    @error('price')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- 2.1 Animal Type Select (မွေးမြူရေး ရွေးထားမှ ပေါ်မည်) -->
            <div id="animal-type-container" class="{{ old('category') == 'livestock' ? '' : 'hidden' }}">
                <label for="animal_type_id" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
                    တိရစ္ဆာန် အမျိုးအစား
                </label>
                <select name="animal_type_id"
                        id="animal_type_id"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm outline-none transition duration-200 bg-white @error('animal_type_id') border-red-500 @enderror">
                    <option value="" selected>တိရစ္ဆာန် အမျိုးအစား ရွေးချယ်ပါ (Optional)</option>
                    {{-- Controller မှ $animalTypes Data ပေးပို့ထားပါက အသုံးပြုရန် --}}
                    @if(isset($animalTypes))
                        @foreach($animalTypes as $type)
                            <option value="{{ $type->id }}" {{ old('animal_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('animal_type_id')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- 3. Phone & Location Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <!-- Phone Number (ဖုန်းနံပါတ်) -->
                <div>
                    <label for="phone" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
                        ဆက်သွယ်ရန် ဖုန်းနံပါတ် <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                            <i class="fa-solid fa-phone"></i>
                        </span>
                        <input type="tel"
                               name="phone"
                               id="phone"
                               value="{{ old('phone') }}"
                               placeholder="09xxxxxxxxx"
                               class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm outline-none transition duration-200 @error('phone') border-red-500 @enderror"
                               >
                    </div>
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location / Address (မြို့နယ်/ဒေသ) -->
                <div>
                    <label for="location" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
                        တည်နေရာ/မြို့နယ် <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <input type="text"
                               name="location"
                               id="location"
                               value="{{ old('location') }}"
                               placeholder="ဥပမာ - မိတ္ထီလာမြို့၊ မန္တလေးတိုင်း"
                               class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm outline-none transition duration-200 @error('location') border-red-500 @enderror"
                               >
                    </div>
                    @error('location')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- 4. Description (အသေးစိတ်ဖော်ပြချက်) -->
            <div>
                <label for="description" class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
                    အသေးစိတ် ဖော်ပြချက် <span class="text-red-500">*</span>
                </label>
                <textarea name="description"
                          id="description"
                          rows="4"
                          placeholder="ရောင်းချလိုသော ပစ္စည်း၏ အခြေအနေ၊ အသက်၊ အရေအတွက် နှင့် အခြား အချက်အလက်များကို အသေးစိတ် ရေးသားပေးပါ..."
                          class="w-full p-4 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm outline-none transition duration-200 @error('description') border-red-500 @enderror"
                          >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- 5. Image Upload with Instant Preview -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-2">
                    ဓာတ်ပုံ တင်ရန် <span class="text-xs text-gray-400 font-normal">(အများဆုံး ၁ ပုံ)</span>
                </label>

                <div class="relative">
                    <input type="file"
                           name="image"
                           id="image-input"
                           accept="image/*"
                           class="hidden"
                           onchange="previewImage(event)">

                    <!-- Upload Dropzone Box -->
                    <label for="image-input"
                           id="dropzone"
                           class="flex flex-col items-center justify-center w-full h-44 border-2 border-dashed border-emerald-800/20 rounded-2xl cursor-pointer bg-emerald-50/40 hover:bg-emerald-50/80 transition duration-200 text-center p-4">

                        <div id="upload-placeholder" class="space-y-2">
                            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mx-auto text-amber-600">
                                <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                            </div>
                            <p class="text-xs sm:text-sm font-semibold text-emerald-950">
                                ဓာတ်ပုံရွေးချယ်ရန် နှိပ်ပါ
                            </p>
                            <p class="text-[11px] text-gray-500">
                                PNG, JPG, JPEG (Max: 5MB)
                            </p>
                        </div>

                        <!-- Dynamic Image Preview Container -->
                        <div id="image-preview-container" class="hidden relative w-full h-full">
                            <img id="image-preview" class="w-full h-full object-contain rounded-xl" src="" alt="Preview">
                            <button type="button"
                                    onclick="removeImage(event)"
                                    class="absolute top-1 right-1 bg-red-500 text-white w-7 h-7 rounded-full flex items-center justify-center shadow-lg hover:bg-red-600 transition">
                                <i class="fa-solid fa-xmark text-xs"></i>
                            </button>
                        </div>
                    </label>
                </div>
                @error('image')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- 6. Form Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ url()->previous() }}"
                   class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-100 text-xs sm:text-sm font-bold transition duration-200">
                    မလုပ်တော့ပါ
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-emerald-950 text-xs sm:text-sm font-extrabold shadow-md transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>ပို့စ် တင်မည်</span>
                </button>
            </div>

        </form>

    </div>
</div>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert Trigger Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'အောင်မြင်ပါသည်!',
                text: "{{ session('success') }}",
                confirmButtonText: 'ကောင်းပြီ',
                confirmButtonColor: '#10B981', // Tailwind Emerald or your brand color
                timer: 3500,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'မှားယွင်းနေပါသည်။',
                text: "{{ session('error') }}",
                confirmButtonText: 'ပြန်ကြိုးစားမည်',
                confirmButtonColor: '#EF4444'
            });
        @endif
    });
</script>

<!-- JavaScript Logic -->
<script>
    // တိရစ္ဆာန် မွေးမြူရေး ရွေးချယ်မှ animal_type_id Dropdown ကို ပြသပေးရန် Logic
    function toggleAnimalType(val) {
        const container = document.getElementById('animal-type-container');
        if (val === 'livestock') {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
            document.getElementById('animal_type_id').value = '';
        }
    }

    // Image Preview Logic
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');
        const placeholder = document.getElementById('upload-placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage(event) {
        event.preventDefault();
        event.stopPropagation();

        const input = document.getElementById('image-input');
        const preview = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');
        const placeholder = document.getElementById('upload-placeholder');

        input.value = '';
        preview.src = '';
        previewContainer.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }
</script>
@endsection
