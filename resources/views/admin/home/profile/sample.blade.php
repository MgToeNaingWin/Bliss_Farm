@extends('admin.layouts.master')
@section('content')
 <div class="flex justify-center ">

        <div class="my-2 flex flex-col w-100 2xl:flex-row space-y-4 2xl:space-y-0 2xl:space-x-4 me-3 h-100vh">
            <div class="w-100 items-center 2xl:w-1/3 ">

                <div class="flex-1 bg-gray-200 rounded-lg shadow-xl p-12">


                <div class="flex flex-col items-center">
                <img src="https://vojislavd.com/ta-template-demo/assets/img/profile.jpg" class="w-40 border-4 border-white rounded-full">
                <div class="flex items-center space-x-2 mt-2">
                    <p class="text-2xl">Amanda Ross</p>
                    <span class="bg-blue-500 rounded-full p-1" title="Verified">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100 h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </span>
                </div>
                {{-- <p class="text-gray-700">Senior Software Engineer at Tailwind CSS</p>
                <p class="text-sm text-gray-500">New York, USA</p> --}}
            </div>


                    <h4 class="text-xl text-gray-900 font-bold mb-2">Eidt Your Personal Info</h4>
                    <form action="">
                        <div class="mb-2">
                            <input type="text" name="name" placeholder="Enter User Name..." class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2  w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0 " value="{{old('name')}}">

                    </div>
                    <div class="mb-2">
                            <input type="text" name="name" placeholder="Enter Phone Number..." class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2  w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0 " value="{{old('name')}}">

                    </div>
                    <div class="mb-2">
                            <input type="text" name="name" placeholder="Enter Email..." class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2  w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0 " value="{{old('name')}}">

                    </div>
                    <div class="mb-2">
                            <input type="text" name="name" placeholder="Enter Address..." class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2  w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0 " value="{{old('name')}}">
                    </div>
                    <div class="flex justify-end mt-4">
                        <button class="bg-blue-600 hover:bg-blue-400 transition duration-300 px-3 py-1 rounded-xl text-white">Save Changes</button>
                    </div>
                    </form>
                </div>

            </div>

        </div>

        <div class="my-2 flex flex-col 2xl:flex-row w-100 space-y-4 2xl:space-y-0 2xl:space-x-4">
            <div class="w-100 items-center  2xl:w-1/3">

                <div class="flex-1 bg-gray-200 rounded-lg shadow-xl p-12">


                <div class="flex flex-col items-center">
                <img src="data:image/webp;base64,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" class="w-40 border-4 rounded-full border-white">
                <div class="flex items-center space-x-2 mt-2">
                    <p class="text-2xl">Amanda Ross</p>
                    <span class="bg-blue-500 rounded-full p-1" title="Verified">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100 h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </span>
                </div>
                <p class="text-gray-700">Senior Software Engineer at Tailwind CSS</p>
                <p class="text-sm text-gray-500">New York, USA</p>
            </div>


                    <h4 class="text-xl text-gray-900 font-bold mb-2">Eidt Your Personal Info</h4>
                    <form action="">
                        <div class="mb-2">
                            <input type="text" name="name" placeholder="Enter Old Password..." class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2  w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0 " value="{{old('name')}}">

                    </div>
                    <div class="mb-2">
                            <input type="text" name="name" placeholder="Enter New Password..." class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2  w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0 " value="{{old('name')}}">

                    </div>
                    <div class="mb-2">
                            <input type="text" name="name" placeholder="Enter Confirm Password..." class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2  w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0 " value="{{old('name')}}">

                    </div>
                    {{-- <div class="mb-2">
                            <input type="text" name="name" placeholder="Enter Address..." class=" text-sm rounded-md px-3 py-2 transition duration-500 border-2  w-full border-neutral-300 focus:border-green-500 focus:outline-none focus:ring-0 " value="{{old('name')}}">

                    </div> --}}
                    <div class="flex justify-end mt-4">
                        <button class="bg-blue-600 hover:bg-blue-400 transition duration-300 px-3 py-1 rounded-xl text-white">Change Password</button>
                    </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
@endsection
