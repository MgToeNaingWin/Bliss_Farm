@extends('user.layouts.master')
@section('bdy')

<div class="pt-6 md:pt-8 px-4 sm:px-6 lg:px-22 max-w-7xl  mx-auto">
    <h1 class="mt-30 text-2xl md:text-3xl font-bold mb-3 text-black">Livestock and Poultry Disease</h1>
    <p class="indent-4 text-black leading-relaxed">We protect against diseases that could harm the health, quality, or marketability of our Nation's agricultural animals. With a vast network of partners, our Veterinary Services team helps U.S. producers prevent, control, and when possible, eliminate these diseases from our country.</p>
</div>
<!-- Main Code -->
<div class="grid grid-cols-1 md:grid-cols-[65%_35%] h-auto mb-8 mt-4 border border-dashed border-stone-200 bg-gray-100 rounded shadow mx-22">
    <div class="p-8 md:px-22 ">
        <h2 class="text-2xl font-bold mb-4 text-black">{{$diseaseInfo['disease_title']}}</h2>
        <p class="text-black indent-8 leading-relaxed">
            {{ $diseaseInfo['disease_desc'] }}
        </p>
    </div>

    <div class="w-full md:w-full lg:w-77 h-64 md:h-96 lg:h-100 pr-0 lg:pr-3  py-6 lg:py-10">
        <img
            src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e"
            alt="Beautiful beach"
            class="w-full h-full object-cover" />
    </div>
</div>
<div class="mx-22 indent-8">
    <p>မြန်မာနိုင်ငံရှိအစောဆုံးသော အခြေချမှုများသည် ပျူမြို့ပြနိုင်ငံများနှင့် မွန်ဘုရင့်နိုင်ငံများ၌ဖြစ်ဆုံးခဲ့ရသည်။ ၁၆ ရာစု‌တွင် ဒုတိယမြန်မာနိုင်ငံတော် တောင်ငူအင်ပါယာပေါ်ပေါက်လာခဲ့ပြီး အရှေ့</p>
</div>
<!-- Information Three Deatail -->
<div class="">
    <div class="md:my-5 px-4 sm:mx-6  max-w-fill rounded-2xl  lg:mx-22 transition-all duration-300">
        <div class="flex justify-between bg-gray-100 p-1 rounded-lg">
            <button onclick="showTab('look')" id="btn-look"
                class="w-1/3 py-2 text-md font-bold rounded-md bg-white shadow text-green-600">
                ရောဂါလက္ခဏာ
            </button>
            <button onclick="showTab('prevent')" id="btn-prevent"
                class="w-1/3 py-2 text-md font-bold rounded-md text-gray-600">
                ကြိုတင်ကာကွယ်နည်း
            </button>
            <button onclick="showTab('treat')" id="btn-treat"
                class="w-1/3 py-2 text-md font-bold rounded-md text-gray-600">
                ကုသနည်း
            </button>
        </div>

        <div class=" text-center min-h-[350px] flex flex-col py-6 bg-gray-100 rounded-lg px-14">
            <div id="look">
                <ul class="space-y-2 mt-3">
                    @foreach(explode(',', $diseaseInfo->symptoms) as $symptom)
                    <li class="flex items-start gap-2 text-xl">
                        <span class="text-dark">•</span>
                        <span>{{ trim($symptom) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div id="prevent" class="hidden">
                <ul class="space-y-2 mt-3">
                    @foreach(explode(',', $diseaseInfo->prevent) as $prevent)
                    <li class="flex items-start gap-2 text-xl">
                        <span class="text-dark">•</span>
                        <span>{{ trim($prevent) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div id="treat" class="hidden">
                <ul class="space-y-2 mt-3">
                    @foreach(explode(',', $diseaseInfo->treated) as $treated)
                    <li class="flex items-start gap-2 text-xl">
                        <span class="text-dark">•</span>
                        <span>{{ trim($treated) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>