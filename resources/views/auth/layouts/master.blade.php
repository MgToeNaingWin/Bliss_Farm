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
<body class="bg-green-500">
    <div class="flex flex-col justify-center items-center h-screen ">
        <div class="mb-5">

        </div>
        <form action="" class="flex flex-col justify-center align-middle  p-10 shadow-lg animate-glow shadow-green-300 w-full max-w-lg gap-4 bg-white rounded-2xl">
            <h1 class="text-center text-4xl text-green-700">Register</h1>
            <input type="text" placeholder="Enter User Name" class="rounded-md px-3 py-2 transition duration-500 border-shadow mb-2 w-100">
            <input type="text" placeholder="Enter User Name">
            <input type="text" placeholder="Enter User Name">
        </form>
    </div>
</body>
</html>
