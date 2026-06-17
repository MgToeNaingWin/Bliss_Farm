<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Pliant:ital,wght@0,100..900;1,100..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Bricolage Grotesque', sans-serif;
        }
    </style>
</head>

<body class="overflow-x-hidden m-0 p-0 min-h-screen bg-slate-900">
    <div
        class="absolute top-0 left-0 right-0 z-50 items-center flex justify-between bg-green-500 p-3 shadow-2xl rounded-full mt-5 border-2 border-amber-50 w-[95%] mx-auto">
        <div class="bg-yellow-300 p-2 rounded-full">
            <p class=" fw-bolder text-olive-500 font-bold">Bliss <span class="text-yellow-600"> Farm</span></p>
        </div>
        <ul class="items-center flex justify-center me-5 align-middle">
            <li class="mx-5 text-white font-bold text-lg cursor-pointer">
                <a class="border-b-2 border-transparent hover:border-amber-50 duration-300 ease-in-out transition pb-1">
                    Home
                </a>
            </li>
            <li class="mx-5 text-white font-bold text-lg cursor-pointer">
                <a class="border-b-2 border-transparent hover:border-amber-50 duration-300 ease-in-out transition pb-1">
                    Knowledge Hub
                </a>
            </li>
            <li class="mx-5 text-white font-bold text-lg cursor-pointer">
                <a class="border-b-2 border-transparent hover:border-amber-50 duration-300 ease-in-out transition pb-1">
                    Market Rate
                </a>
            </li>
            <li class=" ms-5 animate-glow text-white font-bold text-lg cursor-pointer bg-yellow-300 px-3 py-1 rounded-full">
                <a class="border-b-2 border-transparent hover:border-amber-50 duration-300 ease-in-out transition pb-1 text-olive-500">
                    Signup
                </a>

            </li>
        </ul>
    </div>


    @yield('content')
</body>

</html>
