@extends('admin.layouts.master')
@section('content')
    <div class="bg-gray-100">

        <div class="header sticky top-4 shadow z-50 my-3 h-12 px-10 flex items-center justify-between bg-green-500">
            <h1 class="font-medium text-2xl text-white inline-flex items-center">Manage Diseases Article
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8 ms-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0 1 12 12.75Zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 0 1-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.208 1.44.125 2.104.52 4.136 1.153 6.06M12 12.75a2.25 2.25 0 0 0 2.248-2.354M12 12.75a2.25 2.25 0 0 1-2.248-2.354M12 8.25c.995 0 1.971-.08 2.922-.236.403-.066.74-.358.795-.762a3.778 3.778 0 0 0-.399-2.25M12 8.25c-.995 0-1.97-.08-2.922-.236-.402-.066-.74-.358-.795-.762a3.734 3.734 0 0 1 .4-2.253M12 8.25a2.25 2.25 0 0 0-2.248 2.146M12 8.25a2.25 2.25 0 0 1 2.248 2.146M8.683 5a6.032 6.032 0 0 1-1.155-1.002c.07-.63.27-1.222.574-1.747m.581 2.749A3.75 3.75 0 0 1 15.318 5m0 0c.427-.283.815-.62 1.155-.999a4.471 4.471 0 0 0-.575-1.752M4.921 6a24.048 24.048 0 0 0-.392 3.314c1.668.546 3.416.914 5.223 1.082M19.08 6c.205 1.08.337 2.187.392 3.314a23.882 23.882 0 0 1-5.223 1.082" />
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
