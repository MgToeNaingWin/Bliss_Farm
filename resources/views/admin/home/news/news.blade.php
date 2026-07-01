@extends('admin.layouts.master')
@section('content')
    <div class="bg-gray-100">

        <div class="header sticky top-4 shadow z-50 my-3 h-12 px-10 flex items-center justify-between bg-green-500">
            <h1 class="font-medium text-2xl text-white inline-flex items-center">Manage News
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8 ms-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                </svg>
            </h1>
        </div>
        <div class="flex flex-col mx-3 mt-6 lg:flex-row">
            <div class="w-full  m-1 text-lg ">
                <div class="overflow-x-auto rounded-lg p-3">



                    <div
                        class="bg-white shadow-lg rounded-xl border border-gray-100 relative transform scale-100 text-sm p-4 cursor-default bg-opacity-25 mb-4">
                        <div class="flex items-start">
                            <!-- Left side: Image container -->
                            <div class="m-3 flex justify-center shrink-0">
                                <img src="https://tse1.mm.bing.net/th/id/OIP.C5Yy_j1Xdl5TN7LFDPe5zgHaEK?rs=1&pid=ImgDetMain&o=7&rm=3"
                                    class="w-36 h-28 rounded-lg object-cover">
                            </div>

                            <!-- Right side: Text and other elements -->
                            <div class="grow ml-4">
                                <div class="leading-5 text-gray-500 font-medium"><strong>Taylor Otwel</strong></div>
                                <div class="leading-5 text-gray-900 mt-1">
                                    <p>
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde
                                        consequuntur, sit error veniam blanditiis esse fuga tenetur beatae
                                        pariatur rem ab corporis saepe sapiente modi ipsum totam repellendus
                                        vitae explicabo?
                                    </p>
                                    <a class="text-blue-500 hover:underline" href="#">#231231</a>
                                </div>

                                <div class="leading-5 text-gray-800 flex justify-between items-center mt-3">
                                    <div class="text-gray-600">26 / 6 / 2026</div>

                                    <div class="flex items-center">
                                        <a href=""
                                            class="inline-flex text-xs items-center m-1 bg-green-500 hover:bg-blue-600 duration-200 text-white px-2 rounded py-1">
                                            <span>Edit</span>
                                        </a>
                                        <a href=""
                                            class="inline-flex text-xs items-center m-1 bg-green-500 hover:bg-red-600 duration-200 text-white px-2 rounded py-1">
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div
                        class="bg-white shadow-lg rounded-xl border border-gray-100 relative transform scale-100 text-sm p-4 cursor-default bg-opacity-25 mb-4">
                        <div class="flex items-start">
                            <!-- Left side: Image container -->
                            <div class="m-3 flex justify-center shrink-0">
                                <img src="https://tse1.mm.bing.net/th/id/OIP.C5Yy_j1Xdl5TN7LFDPe5zgHaEK?rs=1&pid=ImgDetMain&o=7&rm=3"
                                    class="w-36 h-28 rounded-lg object-cover">
                            </div>

                            <!-- Right side: Text and other elements -->
                            <div class="grow ml-4">
                                <div class="leading-5 text-gray-500 font-medium"><strong>Taylor Otwel</strong></div>
                                <div class="leading-5 text-gray-900 mt-1">
                                    <p>
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde
                                        consequuntur, sit error veniam blanditiis esse fuga tenetur beatae
                                        pariatur rem ab corporis saepe sapiente modi ipsum totam repellendus
                                        vitae explicabo?
                                    </p>
                                    <a class="text-blue-500 hover:underline" href="#">#231231</a>
                                </div>

                                <div class="leading-5 text-gray-800 flex justify-between items-center mt-3">
                                    <div class="text-gray-600">26 / 6 / 2026</div>

                                    <div class="flex items-center">
                                        <a href=""
                                            class="inline-flex text-xs items-center m-1 bg-green-500 hover:bg-blue-600 duration-200 text-white px-2 rounded py-1">
                                            <span>Edit</span>
                                        </a>
                                        <a href=""
                                            class="inline-flex text-xs items-center m-1 bg-green-500 hover:bg-red-600 duration-200 text-white px-2 rounded py-1">
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div
                        class="bg-white shadow-lg rounded-xl border border-gray-100 relative transform scale-100 text-sm p-4 cursor-default bg-opacity-25 mb-4">
                        <div class="flex items-start">
                            <!-- Left side: Image container -->
                            <div class="m-3 flex justify-center shrink-0">
                                <img src="https://tse1.mm.bing.net/th/id/OIP.C5Yy_j1Xdl5TN7LFDPe5zgHaEK?rs=1&pid=ImgDetMain&o=7&rm=3"
                                    class="w-36 h-28 rounded-lg object-cover">
                            </div>

                            <!-- Right side: Text and other elements -->
                            <div class="grow ml-4">
                                <div class="leading-5 text-gray-500 font-medium"><strong>Taylor Otwel</strong></div>
                                <div class="leading-5 text-gray-900 mt-1">
                                    <p>
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde
                                        consequuntur, sit error veniam blanditiis esse fuga tenetur beatae
                                        pariatur rem ab corporis saepe sapiente modi ipsum totam repellendus
                                        vitae explicabo?
                                    </p>
                                    <a class="text-blue-500 hover:underline" href="#">#231231</a>
                                </div>

                                <div class="leading-5 text-gray-800 flex justify-between items-center mt-3">
                                    <div class="text-gray-600">26 / 6 / 2026</div>

                                    <div class="flex items-center">
                                        <a href=""
                                            class="inline-flex text-xs items-center m-1 bg-green-500 hover:bg-blue-600 duration-200 text-white px-2 rounded py-1">
                                            <span>Edit</span>
                                        </a>
                                        <a href=""
                                            class="inline-flex text-xs items-center m-1 bg-green-500 hover:bg-red-600 duration-200 text-white px-2 rounded py-1">
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div
                        class="bg-white shadow-lg rounded-xl border border-gray-100 relative transform scale-100 text-sm p-4 cursor-default bg-opacity-25 mb-4">
                        <div class="flex items-start">
                            <!-- Left side: Image container -->
                            <div class="m-3 flex justify-center shrink-0">
                                <img src="https://tse1.mm.bing.net/th/id/OIP.C5Yy_j1Xdl5TN7LFDPe5zgHaEK?rs=1&pid=ImgDetMain&o=7&rm=3"
                                    class="w-36 h-28 rounded-lg object-cover">
                            </div>

                            <!-- Right side: Text and other elements -->
                            <div class="grow ml-4">
                                <div class="leading-5 text-gray-500 font-medium"><strong>Taylor Otwel</strong></div>
                                <div class="leading-5 text-gray-900 mt-1">
                                    <p>
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde
                                        consequuntur, sit error veniam blanditiis esse fuga tenetur beatae
                                        pariatur rem ab corporis saepe sapiente modi ipsum totam repellendus
                                        vitae explicabo?
                                    </p>
                                    <a class="text-blue-500 hover:underline" href="#">#231231</a>
                                </div>

                                <div class="leading-5 text-gray-800 flex justify-between items-center mt-3">
                                    <div class="text-gray-600">26 / 6 / 2026</div>

                                    <div class="flex items-center">
                                        <a href=""
                                            class="inline-flex text-xs items-center m-1 bg-green-500 hover:bg-blue-600 duration-200 text-white px-2 rounded py-1">
                                            <span>Edit</span>
                                        </a>
                                        <a href=""
                                            class="inline-flex text-xs items-center m-1 bg-green-500 hover:bg-red-600 duration-200 text-white px-2 rounded py-1">
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="flex justify-end mt-4">
                        <a href=""
                            class="inline-flex text-sm items-center m-2 bg-green-500 text-white px-2 rounded py-1"><span>Back</span></a>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
