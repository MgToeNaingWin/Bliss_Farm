@extends('user.layouts.master')
@section('bdy')
<div class="pt-25 px-9">
    <div class="mx-auto grid max-w-6xl grid-cols-12 gap-4 bg-gray-100 shadow mt-7">
        <div class="col-span-12  border-gray-500  sm:col-span-7">
            <div>
                <img src="{{ asset('masterImages/cowsi.jpeg') }}" class="w-300 h-110" alt="">
            </div>
            <div class="flex bg-red-100">
                <p class="m-3 flex-1">
                    <span class="font-medium">Posted On:</span>{{ $single_news['created_at'] }}
                </p>
                <p class="m-3 ">Posted by {{ $single_news['writer'] }}</p>
                </p>
            </div>
        </div>
        <div class="col-span-12  border-gray-400 bg-gray-100 p-8 sm:col-span-5">
            <p class="font-bold leading-relaxed text-blue-gray-900 line-clamp-1 p-2 flex-1">
                {{ $single_news['title'] }}
            </p>
            <div class="h-80 overflow-y-auto pr-2 shadow">
                @php
                // Split the entire text by newlines into an array
                $paragraphs = array_filter(explode("\n", $single_news['description']));
                @endphp
                @foreach($paragraphs as $paragraph)
                <p class="indent-8 mb-4 last:mb-0">
                    {{ trim($paragraph) }}
                </p>
                @endforeach

            </div>
            <div class="pl-87 pt-7">
            <button class="px-3 py-1.5 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
            <a href="/news">Back</a>
            </button>
            </div>

        </div>

    </div>
</div>