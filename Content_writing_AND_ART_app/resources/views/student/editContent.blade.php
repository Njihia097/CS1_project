<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
    #editor-container {
        height: 80vh;
        width: 100%;
    }

    .ql-container {
        border-color: white;
    }

    .ql-editor img {
        padding: 1.5rem;
        max-width: 150px;
        height: 450px;
        display: block;
        margin: 0 auto;
    }

    .image-loader {
        display: none;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
    }

    .image-loader.show {
        display: block;
    }

    .ql-editor .caption {
        display: block;
        text-align: center;
        font-style: italic;
        font-size: 0.9em;
        color: #555;
        -ms-flex-align: center;
        justify-content: center;
    }

    /* Sticky toolbar */
    .ql-toolbar.ql-snow {
    position: sticky;
    top: 0;
    z-index: 10;
    background: white;
    }

    </style>
</head>
<body>
<x-app-layout>
    <form method="POST" id="content-form" action="{{ route('student.updateContent', $content->ContentID) }}">
        @csrf
        @method('PUT')
        <div class="flex items-center justify-between px-4 mx-auto mt-4 border-b border-gray-100 max-w-7xl">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img src="{{ asset('cover_images/' . $content->thumbnail) }}" alt="Content's coverpage" class="object-contain w-20 h-20">
                </div>
                <h3 class="ml-4 text-2xl font-semibold text-gray-700">{{ $content->Title }}</h3>
            </div>

            <div class="flex justify-end">
                <x-button type="button" onclick="setAction('save')">
                    {{ __('Save Content') }}
                </x-button>
                <button type="button" onclick="setAction('publish')" class="inline-flex items-center px-4 py-2 ml-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-800 border border-transparent rounded-md hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50">
                    Publish
                </button>
            </div>
        </div>

        @if(session('error'))
        <div class="flex items-center justify-center text-sm text-red-600">
            {{ session('error')}}
        </div>
        @endif
        
        <!-- Title input field moved here -->
        <div class="flex flex-col items-center justify-center px-6 mt-6 mb-6">
            <input type="text" name="title" id="title" value="{{ $content->Title }}" class="flex items-center justify-center w-2/4 mb-4 text-3xl font-semibold text-gray-700 border-none focus:outline-none" style="background: transparent;">
        </div>

        <!-- Editor container -->
        <div class="flex flex-col items-center px-6 mb-6">
            <input type="hidden" name="content_delta" id="content-delta">
            <input type="hidden" name="action" id="action" value="">
            <div id="editor-container" class="w-full mb-6"></div>
        </div>
    </form>
</x-app-layout>


    <div class="image-loader" id="image-loader">
        <img src="/path/to/loader.gif" alt="Loading...">
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
    <script src="{{ asset('js/quill.js') }}"></script>
</head>
<body>

</body>
</html>
