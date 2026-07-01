@extends('user.layouts.master')
@section('bdy')

<div class="pt-6 md:pt-8 px-4 sm:px-6 lg:px-22 max-w-7xl  mx-auto">
    <h1 class="mt-30 text-2xl md:text-3xl font-bold mb-3 text-black">Livestock and Poultry Disease</h1>
    <p class="indent-4 text-black leading-relaxed">We protect against diseases that could harm the health, quality, or marketability of our Nation's agricultural animals. With a vast network of partners, our Veterinary Services team helps U.S. producers prevent, control, and when possible, eliminate these diseases from our country.</p>
</div>

<!-- Main Code -->

<div class="grid grid-cols-1 md:grid-cols-[65%_35%] h-auto mb-8 mt-4 border border-dashed border-stone-200 bg-gray-100 rounded shadow mx-22">
    <div class="p-8 md:px-22 ">
        <h2 class="text-2xl font-bold mb-4 text-black">{{ $diseaseType['type_title'] }}</h2>
        <p class="text-black indent-8 leading-relaxed">
            {{ $diseaseType['type_desc'] }}
    </div>

    <div class="w-full md:w-full lg:w-77 h-64 md:h-96 lg:h-100 pr-0 lg:pr-3  py-6 lg:py-10">
        <img src="{{ asset('storage/' . $diseaseType->type_img) }}" width="100"
            class="w-full h-full object-cover" />
    </div>
</div>

<!-- Real Disease Info Guider-->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mx-22 mb-16">
    @foreach ($diseaseInfo as $Info)
    <div class="bg-gray-100 shadow-lg  p-4 ">
        <h2 class="text-2xl font-bold mb-3">
            {{ $Info['disease_title'] }}
        </h2>
        <div>
    @php
        $text = $Info['disease_desc'];
        $sentences = array_filter(array_map('trim', preg_split('/။/u', $text)));
        $first_sentence = $sentences[0] ?? $text;
    @endphp
    <p class="block indent-8 text-sm antialiased font-medium leading-normal text-dark line-clamp-2">
        {{ $first_sentence }}...
    </p>
</div>
        <div class="flex justify-end mt-14">
            <a href="{{ $Info['animal_type_id'] }}/{{$Info['id']}}" class="group">
                <i class="fa-solid fa-arrow-right text-3xl transition-all duration-300 group-hover:translate-x-2 group-hover:scale-x-125 origin-left"></i>
            </a>
        </div>
    </div>
    @endforeach
</div>