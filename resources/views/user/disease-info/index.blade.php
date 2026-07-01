@extends('user.layouts.master')
@section('bdy')
<div class="pt-6 md:pt-2 px-4 sm:px-6 lg:px-22 max-w-7xl mx-auto">
    <h1 class="mt-30 text-2xl md:text-3xl font-bold mb-3 ">Livestock and Poultry Disease</h1>
    <p class="indent-4  leading-relaxed">We protect against diseases that could harm the health, quality, or marketability of our Nation's agricultural animals. With a vast network of partners, our Veterinary Services team helps U.S. producers prevent, control, and when possible, eliminate these diseases from our country.</p>
</div>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-22 my-6">
    <div class="relative flex flex-col shadow-sm min-w-0 bg-clip-border rounded-[.95rem] border border-dashed border-stone-200 bg-gray-100 p-6 md:p-8">
        <div class="mb-8">
            <h2 class="mb-2 text-2xl font-semibold text-black">Our Executive Team</h2>
            <span class="text-base font-medium text-black"> Meet our talented team, a dynamic group of experts driven by passion and innovation. </span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 w-full">
            <div class="flex flex-col text-center bg-white p-4 rounded-[.95rem] shadow-sm lg:bg-transparent lg:p-0 lg:shadow-none">
                <div class="inline-block mb-4 relative shrink-0 rounded-[.95rem]">
                    <img class="inline-block shrink-0 rounded-[.95rem] w-[175px] h-[175px] object-cover mx-auto" src="https://images2.alphacoders.com/107/thumb-1920-1073550.jpg" alt="Cattle">
                </div>
                <div class="text-center flex flex-col justify-between h-full">
                    <p class="text-gray-800 font-semibold text-[1.05rem] transition-colors duration-200 min-h-[3rem] flex items-center justify-center">နွားများနှင့် သက်ဆိုင်သော</p>
                    <span class="text-blue-600 mt-2 block"><a href="/disease-info/1" class="hover:underline">ဖတ်ရန် <i class="fa-solid fa-arrow-right-long ml-1"></i></a></span>
                </div>
            </div>
            <div class="flex flex-col text-center bg-white p-4 rounded-[.95rem] shadow-sm lg:bg-transparent lg:p-0 lg:shadow-none">
                <div class="inline-block mb-4 relative shrink-0 rounded-[.95rem]">
                    <img class="inline-block shrink-0 rounded-[.95rem] w-[175px] h-[175px] object-cover mx-auto" src="https://c4.wallpaperflare.com/wallpaper/447/122/361/pig-little-pig-countryside-hooves-wallpaper-preview.jpg" alt="Pigs">
                </div>
                <div class="text-center flex flex-col justify-between h-full">
                    <p class="text-gray-800 font-semibold  text-[1.05rem] transition-colors duration-200 min-h-[3rem] flex items-center justify-center">ဝက်များနှင့် သက်ဆိုင်သော</p>
                    <span class="text-blue-600 mt-2 block"><a href="/disease-info/2" class="hover:underline">ဖတ်ရန် <i class="fa-solid fa-arrow-right-long ml-1"></i></a></span>
                </div>
            </div>
            <div class="flex flex-col text-center bg-white p-4 rounded-[.95rem] shadow-sm lg:bg-transparent lg:p-0 lg:shadow-none">
                <div class="inline-block mb-4 relative shrink-0 rounded-[.95rem]">
                    <img class="inline-block shrink-0 rounded-[.95rem] w-[175px] h-[175px] object-cover mx-auto" src="https://img.magnific.com/free-photo/close-up-beautiful-chickens_23-2150741669.jpg?semt=ais_hybrid&w=740&q=80" alt="Poultry">
                </div>
                <div class="text-center flex flex-col justify-between h-full">
                    <p class="text-gray-800 font-semibold  text-[1.05rem] transition-colors duration-200 min-h-[3rem] flex items-center justify-center">ကြက်များနှင့် သက်ဆိုင်သော</p>
                    <span class="text-blue-600 mt-2 block"><a href="/disease-info/3" class="hover:underline">ဖတ်ရန် <i class="fa-solid fa-arrow-right-long ml-1"></i></a></span>
                </div>
            </div>
            <div class="flex flex-col text-center bg-white p-4 rounded-[.95rem] shadow-sm lg:bg-transparent lg:p-0 lg:shadow-none">
                <div class="inline-block mb-4 relative shrink-0 rounded-[.95rem]">
                    <img class="inline-block shrink-0 rounded-[.95rem] w-[175px] h-[175px] object-cover mx-auto" src="https://media.istockphoto.com/id/1163834249/photo/tilapia-freshwater-fish-economic-fish-that-can-be-cultivated-in-both-earthen-ponds-and-cages.jpg?s=612x612&w=0&k=20&c=-cpoceuv70Eg9xFhgeeqVrvei9XU1XJ_jYAT0aQmqOU=" alt="Fish">
                </div>
                <div class="text-center flex flex-col justify-between h-full">
                    <p class="text-gray-800 font-semibold  text-[1.05rem] transition-colors duration-200 min-h-[3rem] flex items-center justify-center">ငါးများနှင့် သက်ဆိုင်သော</p>
                    <span class="text-blue-600 mt-2 block"><a href="/disease-info/4" class="hover:underline">ဖတ်ရန် <i class="fa-solid fa-arrow-right-long ml-1"></i></a></span>
                </div>
            </div>
            <div class="flex flex-col text-center bg-white p-4 rounded-[.95rem] shadow-sm lg:bg-transparent lg:p-0 lg:shadow-none">
                <div class="inline-block mb-4 relative shrink-0 rounded-[.95rem]">
                    <img class="inline-block shrink-0 rounded-[.95rem] w-[175px] h-[175px] object-cover mx-auto" src="https://thumbs.dreamstime.com/b/flock-sheep-goat-pasture-nature-goats-graze-meadow-72949555.jpg" alt="Sheep and Goats">
                </div>
                <div class="text-center flex flex-col justify-between h-full">
                    <p class="text-gray-800 font-semibold  text-[1.05rem] transition-colors duration-200 min-h-[3rem] flex items-center justify-center">သိုးနှင့်ဆိတ်များနှင့် သက်ဆိုင်သော</p>
                    <span class="text-blue-600 mt-2 block"><a href="/disease-info/5" class="hover:underline">ဖတ်ရန် <i class="fa-solid fa-arrow-right-long ml-1"></i></a></span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-22 my-10">
    <p class="text-xl md:text-2xl font-semibold mb-4 text-gray-800">We showed the most disease in the farm of livestock</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 p-6 border border-dashed border-stone-200 bg-gray-100 rounded-xl shadow-sm">

        @foreach ($diseaseInfo->take(12) as $disease)
        <ul class="bg-emerald-50/50  rounded-lg flex flex-col gap-3">
            <li>
                <a href="/disease-info/{{ $disease['animal_type_id'] }}/{{$disease['id']}}"
                    class="text-blue-600 hover:text-green-700 hover:underline transition duration-300 flex items-start gap-2">
                    <i class="fa-solid fa-bullhorn mt-0.5 shrink-0 text-sm"></i>
                    <span>
                        {{ $disease->disease_title }}
                    </span>
                </a>
            </li>
        </ul>
        @endforeach

    </div>
</div>
@endsection