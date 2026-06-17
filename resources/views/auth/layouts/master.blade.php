<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
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
<body class="bg-green-500" >
    <div class="flex flex-col justify-center items-center h-screen ">
        <form action="" class="flex flex-col justify-center align-middle  p-10 shadow shadow-green-300 w-full max-w-lg gap-4 bg-white rounded-2xl">
            <div class="flex justify-center">
                <h1 class="text-center text-4xl text-green-700">Register</h1>
                <img src="{{asset('masterImages/logo.png')}}" class="h-12 w-12 border-green-600 border-2 rounded-full ms-5">
            </div>
            <input type="text" placeholder="Enter User Name" class="rounded-md px-3 py-2 transition duration-500 border-2 mb-2 w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0">
            <input type="text" placeholder="Enter Email" class="rounded-md px-3 py-2 transition duration-500 border-2 mb-2 w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0">
            <input type="text" placeholder="Enter Password" class="rounded-md px-3 py-2 transition duration-500 border-2 mb-2 w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0">
            <input type="text" placeholder="Enter Confirm Password" class="rounded-md px-3 py-2 transition duration-500 border-2 mb-2 w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0 focus:border-3">
            <div class="flex items-center justify-center">
                <button class="bg-green-500 text-white py-2 px-3 rounded-2xl mx-2">Sign Up</button>
                <button class="bg-green-500 text-white py-2 px-3 rounded-2xl mx-2">As Guest</button>
            </div>
            <div class="flex justify-center items-center">
                <p class="text-center text-stone-500">Have an account?</p><a href="#" class="ms-2 bold text-indigo-600">Login</a>
            </div>
        </form>
    </div>
</body>
</html>
