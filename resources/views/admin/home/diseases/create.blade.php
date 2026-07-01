@extends('admin.layouts.master')
@section('content')
    <div class="bg-gray-100">

        <div class="header my-3 h-12 px-10 flex items-center justify-between bg-green-500">
            <h1 class="font-medium text-2xl text-white inline-flex items-center">Manage Diseases Atricle
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8 ms-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0 1 12 12.75Zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 0 1-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.208 1.44.125 2.104.52 4.136 1.153 6.06M12 12.75a2.25 2.25 0 0 0 2.248-2.354M12 12.75a2.25 2.25 0 0 1-2.248-2.354M12 8.25c.995 0 1.971-.08 2.922-.236.403-.066.74-.358.795-.762a3.778 3.778 0 0 0-.399-2.25M12 8.25c-.995 0-1.97-.08-2.922-.236-.402-.066-.74-.358-.795-.762a3.734 3.734 0 0 1 .4-2.253M12 8.25a2.25 2.25 0 0 0-2.248 2.146M12 8.25a2.25 2.25 0 0 1 2.248 2.146M8.683 5a6.032 6.032 0 0 1-1.155-1.002c.07-.63.27-1.222.574-1.747m.581 2.749A3.75 3.75 0 0 1 15.318 5m0 0c.427-.283.815-.62 1.155-.999a4.471 4.471 0 0 0-.575-1.752M4.921 6a24.048 24.048 0 0 0-.392 3.314c1.668.546 3.416.914 5.223 1.082M19.08 6c.205 1.08.337 2.187.392 3.314a23.882 23.882 0 0 1-5.223 1.082" />
                </svg>
            </h1>
        </div>
        <div class="flex flex-col mx-3 mt-6 lg:flex-row">
            <div class="w-full lg:w-2/3 m-1">
                <form class="w-full bg-white shadow-md p-6">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-full px-3 mb-6">
                            <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                htmlFor="category_name">Disease Name</label>
                            <input type="text"
                                class="text-gray-700 text-sm rounded-md px-3 py-2 border-2 w-full border-neutral-300 focus:border-neutral-500 focus:outline-none"
                                placeholder="Disease Title..">
                        </div>
                        <div class="w-full px-3 mb-6">
                            <textarea textarea rows="4"
                                class="text-gray-700 text-sm rounded-md px-3 py-2 border-2 w-full border-neutral-300 focus:border-neutral-500 focus:outline-none"
                                type="text" name="description" required> Disease Description... </textarea>
                        </div>

                        <div class="w-full md:w-full px-3 mb-6">
                            <button
                                class="appearance-none block w-full bg-green-500 text-gray-100 font-bold border border-gray-200 rounded-lg py-3 px-3 leading-tight hover:bg-green-600 focus:outline-none focus:bg-white focus:border-gray-500">Post</button>
                        </div>

                        <div class="w-full px-3 mb-8">
                            <label
                                class="mx-auto cursor-pointer flex w-full max-w-lg flex-col items-center justify-center rounded-xl border-2 border-dashed border-green-400 bg-white p-6 text-center"
                                htmlFor="dropzone-file">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-800" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                                    <path strokeLinecap="round" strokeLinejoin="round"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>

                                <h2 class="mt-4 text-xl font-medium text-gray-700 tracking-wide">Disease image</h2>

                                <p class="mt-2 text-gray-500 tracking-wide">Upload or drag & drop your file SVG, PNG, JPG or
                                    GIF. </p>

                                <input id="dropzone-file" type="file" class="hidden" name="category_image"
                                    accept="image/png, image/jpeg, image/webp" />
                            </label>
                        </div>

                    </div>
                </form>
            </div>
            <div class="w-full lg:w-1/3 m-1 bg-white shadow-lg text-lg rounded-sm border border-gray-200">
                <div class="overflow-x-auto rounded-lg p-3">
                    <table class="w-full">


                        <tbody class="">
                            <tr
                                class="relative transform scale-100
                                        text-sm py-1 border-b-2 border-blue-100 cursor-default

                                 bg-opacity-25">
                                <td class="px-2 py-2 whitespace-no-wrap">
                                    <div class="leading-5 text-gray-500 font-medium"><strong> Taylor Otwel</strong></div>
                                    <div class="leading-5 text-gray-900">
                                    <p>
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nulla blanditiis veniam obcaecati commodi...
                                    </p>
                                        <a class="text-blue-500 hover:underline" href="#">#231231</a>
                                    </div>
                                    <div class="leading-5 text-gray-800 flex justify-between items-center">
                                            <div>26 / 6 / 2026</div>
                                        <a href=""
                                            class="inline-flex text-xs items-center m-2 bg-green-500 text-white px-2 rounded py-1">
                                            <span>See More</span>
                                        </a>
                                    </div>
                                </td>


                            </tr>

                            <tr
                                class="relative transform scale-100
                                        text-sm py-1 border-b-2 border-blue-100 cursor-default

                                 bg-opacity-25">
                                <td class="px-2 py-2 whitespace-no-wrap">
                                    <div class="leading-5 text-gray-500 font-medium"><strong> Taylor Otwel</strong></div>
                                    <div class="leading-5 text-gray-900">
                                    <p>
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nulla blanditiis veniam obcaecati commodi...
                                    </p>
                                        <a class="text-blue-500 hover:underline" href="#">#231231</a>
                                    </div>
                                    <div class="leading-5 text-gray-800 flex justify-between items-center">
                                            <div>26 / 6 / 2026</div>
                                        <a href=""
                                            class="inline-flex text-xs items-center m-2 bg-green-500 text-white px-2 rounded py-1">
                                            <span>See More</span>
                                        </a>
                                    </div>
                                </td>


                            </tr>

                            <tr
                                class="relative transform scale-100
                                        text-sm py-1 border-b-2 border-blue-100 cursor-default

                                 bg-opacity-25">
                                <td class="px-2 py-2 whitespace-no-wrap">
                                    <div class="leading-5 text-gray-500 font-medium"><strong> Taylor Otwel</strong></div>
                                    <div class="leading-5 text-gray-900">
                                    <p>
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nulla blanditiis veniam obcaecati commodi...
                                    </p>
                                        <a class="text-blue-500 hover:underline" href="#">#231231</a>
                                    </div>
                                    <div class="leading-5 text-gray-800 flex justify-between items-center">
                                            <div>26 / 6 / 2026</div>
                                        <a href=""
                                            class="inline-flex text-xs items-center m-2 bg-green-500 text-white px-2 rounded py-1">
                                            <span>See More</span>
                                        </a>
                                    </div>
                                </td>


                            </tr>



                        </tbody>
                    </table>
                   <div class="flex justify-end mt-4">
                     <a href="" class="inline-flex text-xs items-center m-2 bg-green-500 text-white px-2 rounded py-1"><span>Manage All</span></a>
                   </div>
                </div>
            </div>

        </div>

    </div>
@endsection
