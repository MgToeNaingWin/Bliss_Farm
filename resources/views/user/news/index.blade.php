@extends('user.layouts.master')
@section('bdy')

<div class="relative w-screen h-screen bg-cover bg-center bg-no-repeat bg-white">

<div class="pt-30 md:pt-30 px-4 sm:px-6 lg:px-22 max-w-7xl mx-auto">
    <h1 class="text-2xl md:text-3xl font-bold mb-3 text-gray-800">Livestock and Poultry Disease</h1>
    <p class="indent-4 md:indent-6 p-3 text-gray-600 leading-relaxed">
        ကျွန်ုပ်တို့ သုခခြံ websiteမှ ဒေသတွင်းမွေးမြူသော တိရစ္ဆာန် များ၏ ကျန်းမာရေးနှင့်ပက်သက်သော သတင်းများကို ည၆နာရီ အချိန်တွင် အစဉ်မပြတ် update တင်ပေးနေပါသဖြင့် စောင့်မျှော် ကြည့်ရှူပေးပါရန်......
    </p>
</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 p-15 max-w-full mx-auto">

            @foreach($news as $item)
            <div class="relative flex flex-col text-gray-700 bg-gray-200 shadow-md bg-clip-border rounded-xl w-full">
                <div class="relative mx-3 mt-3 overflow-hidden text-gray-700 bg-     bg-clip-border rounded-xl h-48">
                    <img
                        src="https://images.unsplash.com/photo-1629367494173-c78a56567877?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=927&amp;q=80"
                        alt="card-image" class="object-cover w-full h-full" />
                </div>
                <div class="p-4 grow">
                    <div class="flex flex-col mb-2">
                        <p class="block text-sm antialiased font-bold leading-relaxed text-blue-gray-900 line-clamp-1">
                            {{ $item['title'] }}
                        </p>
                        <p class="block text-xs antialiased leading-relaxed text-gray-500">
                            By {{ $item['writer'] }}
                        </p>
                    </div>
                    @php
                    $text = $item['description'];
                    $sentences = preg_split('/(?<=။)\s* /u', $text);
                        $first_sentence=!empty($sentences) ? trim($sentences[0]) : $text;
                        @endphp

                        <p class="block text-sm antialiased font-normal leading-normal text-gray-700 opacity-75 line-clamp-2">
                        {{ $first_sentence }}...
                        </p>
                </div>
                <div class="p-3 pt-0 mt-auto">
                    <button
                        class="align-middle select-none font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-2 px-4 rounded-lg shadow-gray-900/10 hover:shadow-gray-900/20 focus:opacity-[0.85] active:opacity-[0.85] active:shadow-none block w-full bg-blue-gray-900/10 text-blue-gray-900 shadow-none hover:scale-105 hover:shadow-none focus:scale-105 focus:shadow-none active:scale-100"
                        type="button"><a href="/news/{{ $item['id'] }}">
                            See More
                        </a>
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8 max-w-7xl mx-auto pl-7 pr-80">
            {!! $news->links() !!}
        </div>
    </div>

    <div class="inset-0 bg-black/50"></div>
</div>
@endsection