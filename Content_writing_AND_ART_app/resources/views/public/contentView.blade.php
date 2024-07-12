<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/quill.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Make sure you have Tailwind CSS -->
</head>
<body>
    <x-app-layout>
    <div class="fixed z-40 flex flex-col items-center justify-between w-full px-4 pt-2 mx-auto mt-0 bg-white shadow-sm md:flex-row max-w-7xl">
            <div class="flex items-center mb-2 space-x-4 md:mb-0">
                <a href="#"><i class="text-3xl fa-solid fa-chevron-left"></i></a> 
                <div class="flex-shrink-0">
                    <img src="{{ asset('img/hero-1.jpg') }}" alt="Content's coverpage" class="object-contain w-20 h-20 rounded-lg">
                </div>
                <div class="relative">
                    <div class="flex items-center">
                        <h3 class="text-xl font-semibold text-gray-700 md:text-2xl">In the Beninging</h3>
                        <button id="dropdownButton" class="ml-2 text-gray-700 focus:outline-none">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <!-- Dropdown Menu -->
                    <div id="dropdownMenu" class="absolute hidden w-48 mt-2 bg-white border rounded-md shadow-lg">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Chapter 1</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Chapter 2</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Chapter 3</a>
                        <!-- Add more chapters as needed -->
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-2 space-y-2">
                <x-button type="button">
                    {{ __('Edit Content') }}
                </x-button>
            </div>
        </div>

        <div class="pt-20">
            @if(session('error'))
                <div class="flex items-center justify-center text-sm text-red-600">
                    {{ session('error')}}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- New Section for Content Details -->
        <div class="py-10 bg-gray-100">
            <div class="max-w-4xl p-6 mx-auto bg-white rounded-lg shadow-md">
                <div class="flex flex-col items-center space-y-4">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold">In The Benigning</h2>
                        <p class="mt-2 text-gray-500"></p>
                        <p class="text-gray-500"></p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <i class="text-gray-500 fa-regular fa-comment"></i>
                            <span class="ml-1 text-gray-500">10</span>
                        </div>
                        <div class="flex items-center">
                            <i class="text-gray-500 fa-regular fa-thumbs-up"></i>
                            <span class="ml-1 text-gray-500">5</span>
                        </div>
                        <div class="flex items-center">
                            <i class="text-gray-500 fa-regular fa-thumbs-down"></i>
                            <span class="ml-1 text-gray-500">2</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center col-span-1 space-x-4 ">
                        <img src="{{ asset('img/avatar.jpg') }}" alt="Author" class="w-10 h-10 rounded-full">
                        <p class="text-gray-700">by Jessica-Carter</p>
                    </div>
                </div>
                <div class="mt-6 text-gray-700">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <p class="mt-4">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
                <div class="mt-6 text-center">
                    <a href="#" class="px-6 py-3 text-white bg-blue-600 rounded-full hover:bg-blue-700">Start Reading</a>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>
    <script>
        document.getElementById('dropdownButton').addEventListener('click', function () {
            var menu = document.getElementById('dropdownMenu');
            menu.classList.toggle('hidden');
        });
    </script>
</html>
