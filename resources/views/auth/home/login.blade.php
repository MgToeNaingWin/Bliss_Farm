@extends('auth.layouts.master')
@section('content')
<form action="{{route('login')}}" method="POST" class="flex flex-col justify-center align-middle  p-7 shadow shadow-green-300 w-full max-w-lg gap-4 bg-white rounded-2xl">
    @csrf
    <div class="flex justify-center">
                <h1 class="text-center text-4xl text-green-700">Welcome Back</h1>
            </div>
            <div class="flex justify-center">
                <h2 class="text-center text-2xl text-green-700">Login</h2>
                <img src="{{asset('masterImages/logo.png')}}" class="h-8 w-8 border-green-600 border-2 rounded-full ms-3">
            </div>

            <input type="email" name="email" placeholder="Enter Email" class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2 mb-2 w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0">
            <input type="password" name="password" placeholder="Enter Password" class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2 mb-2 w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0">

                <x-form-button>Login</x-form-button>
                <x-social-login-button> <i class="fa-brands fa-google me-2"></i> Login With Google</x-social-login-button>


            <div class="flex justify-center items-center">
                <p class="text-center text-stone-500">Have Not an account?</p><a href="{{route('register')}}" class="ms-2 font-bold text-indigo-600">Register</a>

            </div>
        </form>
@endsection
