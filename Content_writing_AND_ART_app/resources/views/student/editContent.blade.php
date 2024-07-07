<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content</title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/quill.css') }}" >

</head>
<body onbeforeunload="return checkForUnsavedChanges()">
    <x-app-layout>
        <form method="POST" id="content-form" action="{{ route('student.updateContent', $content->ContentID) }}">
            @csrf
            @method('PUT')
            <div class="fixed z-40 flex items-center justify-between w-full px-4 pt-2 mx-auto mt-0 bg-gray-100 max-w-7xl">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('cover_images/' . $content->thumbnail) }}" alt="Content's coverpage" class="object-contain w-20 h-20">
                    </div>
                    <h3 class="ml-4 text-2xl font-semibold text-gray-700">{{ $content->Title }}</h3>
                </div>
                <div class="flex">
                    <label id="save-status" disabled type="button" class="inline-flex items-center text-sm font-medium text-green-800 border me-2 hover:bg-gray-100 hover:text-green-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-green-700 focus:text-green-700">
                        <svg id="save-loader" aria-hidden="true" role="status" class="hidden w-4 h-4 text-gray-200 me-3 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                        </svg>
                        
                    </label>
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
            <div class="flex items-center justify-center text-sm text-green-600">
                {{ session('error')}}
            </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="pt-16">
                    <!-- Title input field moved here -->
                
                <input type="hidden" id="content_type" value="{{ $content->IsChapter ? 'chapter' : 'story' }}">

                <div class="flex flex-col items-center justify-center w-full px-6 mt-6 mb-2" id="chapter-title-container">
                    <input type="text" name="chapter_title" id="chapter_title" 
                    value="{{ $chapterTitle }}" 
                    class="flex items-center justify-center w-2/4 mb-4 text-3xl font-semibold text-gray-700 border-none focus:outline-none" style="background: transparent;">
                </div>

                <div class="flex flex-col items-center justify-center w-full px-6 mt-6 mb-2" id="story-title-container">
                    <input type="text" name="title" id="title" 
                    value="{{ $content->Title }}" 
                    class="flex items-center justify-center w-2/4 mb-4 text-3xl font-semibold text-gray-700 border-none focus:outline-none" style="background: transparent;">
                </div>
              

                <!-- Editor container -->
                <div class="flex flex-col items-center px-6 mb-0">
                    <input type="hidden" name="content_delta" id="content-delta">
                    <input type="hidden" name="action" id="action" value="">
                    <div id="editor-container" class="w-full mb-6"></div>
                </div>
            </div>
        </form>
    </x-app-layout>


   
        <div class="image-loader" id="image-loader"></div>
 
        
    


    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>
    <script>
        const contentID = '{{ $content->ContentID }}';
    </script>
  
    <script>
        let isContentChanged = false;

        // Function to check for unsaved changes
        function checkForUnsavedChanges() {
            if (isContentChanged) {
                return "You have unsaved changes. Do you really want to leave?";
            }
        }
    </script>
    <script src="{{ asset('js/quill.js') }}"></script>

</body>
</html>
