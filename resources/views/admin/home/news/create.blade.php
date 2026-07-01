@extends('admin.layouts.master')
@section('content')
    <div class="bg-gray-100">

        <div class="header my-3 h-12 px-10 flex items-center justify-between bg-green-500">
            <h1 class="font-medium text-2xl text-white inline-flex items-center">Manage News
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 ms-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                </svg>
            </h1>
        </div>
        <div class="flex flex-col mx-3 mt-6 lg:flex-row">
            <div class="w-full lg:w-2/3 m-1">
                <form class="w-full bg-white shadow-md p-6">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-full px-3 mb-6">
                            <label class="block uppercase tracking-wide text-gray-700 text-sm font-bold mb-2"
                                htmlFor="category_name">News Title</label>
                            <input type="text"
                                class="text-gray-700 text-sm rounded-md px-3 py-2 border-2 w-full border-neutral-300 focus:border-neutral-500 focus:outline-none"
                                placeholder="News Title..">
                        </div>
                        <div class="w-full px-3 mb-6">
                            <textarea textarea rows="4"
                                class="text-gray-700 text-sm rounded-md px-3 py-2 border-2 w-full border-neutral-300 focus:border-neutral-500 focus:outline-none"
                                type="text" name="description" required> News Description... </textarea>
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

                                <h2 class="mt-4 text-xl font-medium text-gray-700 tracking-wide">New image</h2>

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
