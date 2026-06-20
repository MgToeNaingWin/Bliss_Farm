@extends('auth.layouts.master')
@section('content')

<form action="{{route('register')}}" method="POST" class="flex flex-col justify-center align-middle  p-7 shadow shadow-green-300 w-full max-w-lg gap-4 bg-white rounded-2xl">
    @csrf
            <div class="flex justify-center">
                <h1 class="text-center text-4xl text-green-700">Register</h1>
                <img src="{{asset('masterImages/logo.png')}}" class="h-12 w-12 border-green-600 border-2 rounded-full ms-5">
            </div>
            <input type="text" name="name" placeholder="Enter User Name" class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2  w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0 " value="{{old('name')}}">
            @error('name')
                <small class="text-red-300">{{$message}}</small>
            @enderror
            <input type="text" name="email" placeholder="Enter Email" class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2   w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0" value="{{old('email')}}">
            @error('email')
                <small class="text-red-300">{{$message}}</small>
            @enderror
            <input type="password" name="password" placeholder="Enter Password"  class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2   w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0" value="{{old('password')}}">
            @error('password')
                <small class="text-red-300">{{$message}}</small>
            @enderror
            <input type="password" name="password_confirmation" placeholder="Enter Confirm Password" class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2   w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0 focus:border-2" value="{{old('password_confirmation')}}">
            @error('password_confirmation')
                <small class="text-300">{{$message}}</small>
            @enderror

                <x-form-button>Sign Up</x-form-button>
                <x-form-button type="button"><a href="{{route('userHome')}}">As Guest</a></x-form-button>
                <x-social-login-button> <i class="fa-brands fa-google me-2"></i> Login With Google</x-social-login-button>


            <div class="flex justify-center items-center">
                <p class="text-center text-stone-500">Have an account?</p><a href="{{route('login')}}" class="ms-2 font-bold text-indigo-600">Login</a>

            </div>
        </form>

@endsection
