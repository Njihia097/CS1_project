<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/quill.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="home/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/themify-icons.css" type="text/css">
    <link rel="stylesheet" href="home/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="home/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="home/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/style.css" type="text/css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <x-app-layout>
        <div
            class="fixed z-40 flex flex-col items-center justify-between w-full px-4 pt-2 mx-auto mt-0 bg-white shadow-sm md:flex-row max-w-7xl">
            <div class="flex items-center mb-2 space-x-4 md:mb-0">
                <a href="#"><i class="text-3xl fa-solid fa-chevron-left"></i></a>
                <div class="flex-shrink-0">
                    <img src="{{  $content->thumbnail ? asset('cover_images/' . $content->thumbnail) : 'img/banner-3.jpg' }}"
                        alt="Content's coverpage" class="object-cover w-full h-24 py-2 rounded-md">
                </div>
                <div class="relative">
                    <div class="flex items-center">
                        <h3 class="text-xl font-semibold text-gray-700 md:text-2xl">{{ $content->Title}}</h3>
                        @if ($content->IsChapter)
                            <button id="dropdownButton" class="ml-2 text-gray-700 focus:outline-none">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        @endif

                    </div>
                    <!-- Dropdown Menu -->
                    @if ($content->IsChapter)
                        <div id="dropdownMenu" class="absolute hidden w-64 mt-4 bg-white border rounded-md shadow-lg">
                            <div class="flex flex-col items-center justify-center col-span-1 py-3 mb-2 bg-gray-50">
                                <h6 class="items-center text-sm font-semibold text-gray-800">{{$content->Title}}</h6>
                                <p class="flex items-center text-sm text-gray-800">Table of contents</p>
                            </div>
                            @foreach ($content->chapters as $chapter)
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ $chapter->Title }}</a>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>


            @if (Auth::check() && Auth::id() == $content->AuthorID)
                <div class="flex items-center space-x-2 space-y-2">
                    <a href="{{ route('student.contentDetails', ['content' => $content->ContentID]) }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50">Edit
                        Content</a>
                </div>
            @endif
            @if (Auth::check() && Auth::user()->hasRole('editor'))
                <div class="flex space-x-2">
                    @if ($content->Status == 'pending' || $content->Status == 'draft')
                        <button
                            class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded approve-btn hover:bg-green-600 hover:text-white"
                            data-id="{{ $content->ContentID }}">Approve</button>
                        <button
                            class="px-4 py-2 text-sm font-bold text-white bg-red-500 rounded flag-btn hover:bg-red-600 hover:text-white"
                            data-id="{{ $content->ContentID }}">Flag</button>
                            <button
                                id="analyse-sentiment-btn"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600 hover:text-white"
                                data-id="{{ $content->ContentID }}">Analyse Sentiment
                            </button>
                    @else
                        <span class="px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded">Reviewed</span>
                    @endif
                </div>
            @endif
            @if (Auth::check() && Auth::user()->hasRole('admin'))
                <div class="flex space-x-2">
                    @if ($content->Status == 'flagged')
                        <button
                            class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded approve-btn hover:bg-green-600 hover:text-white"
                            data-id="{{ $content->ContentID }}">Approve</button>
                        <button
                            class="px-4 py-2 text-sm font-bold text-white bg-red-500 rounded suspend-btn hover:bg-red-600 hover:text-white"
                            data-id="{{ $content->ContentID }}">Suspend</button>
                    @else
                        <span class="px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded">Reviewed</span>
                    @endif
                </div>
            @endif


        </div>
        <!-- Success and Error Messages -->
        <div id="message" class="fixed hidden p-4 rounded shadow-lg z-1000" role="alert"></div>

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
            @yield('content')
        </div>
    </x-app-layout>
</body>
<div class="image-loader" id="image-loader"></div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
<script>
    document.getElementById('dropdownButton').addEventListener('click', function () {
        var menu = document.getElementById('dropdownMenu');
        menu.classList.toggle('hidden');
    });
</script>
<script>
    document.getElementById('analyse-sentiment-btn').addEventListener('click', function() {
        this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>'; // Show loading spinner
        setTimeout(() => {
            this.innerHTML = '<i class="text-green-500 fa fa-check"></i>'; // Show green tick after 5 seconds
        }, 5000);
    });

    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const contentId = this.dataset.id;
            updateContentStatus(contentId, 'approved', this);
        });
    });

    document.querySelectorAll('.flag-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const contentId = this.dataset.id;
            updateContentStatus(contentId, 'flagged', this);
        });
    });

    document.querySelectorAll('.suspend-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const contentId = this.dataset.id;
            updateContentStatus(contentId, 'suspend', this);
        });
    });

    function updateContentStatus(contentId, status, button) {
        fetch(`/editor/content/${contentId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayMessage('success', `Content ${status} successfully!`);
                    // Update the button to show 'Reviewed' status
                    const parentDiv = button.closest('.flex');
                    parentDiv.innerHTML = '<span class="px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded">Reviewed</span>';
                } else {
                    displayMessage('error', `Failed to ${status} content!`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                displayMessage('error', `Failed to ${status} content!`);
            });
    }

    function displayMessage(type, message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `fixed p-4 rounded shadow-lg z-1000 ${type == 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
        messageDiv.textContent = message;
        document.body.appendChild(messageDiv);
        setTimeout(() => {
            document.body.removeChild(messageDiv);
        }, 3000);
    }
</script>

</html>