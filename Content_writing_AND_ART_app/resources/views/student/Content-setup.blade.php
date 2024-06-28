<x-app-layout>
    
    @if(session('success'))
        <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success')}}
        </div>
    @endif

    @if(session('error'))
        <div class="text-sm text-red-600">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('student.Content-setup') }}" enctype="multipart/form-data">
        <div class="flex flex-col items-start justify-center mt-6 sm:flex-row">
            <!-- Cover Page Image -->
            <div class="mb-6 sm:mr-6 sm:mb-6">
                <label for="cover_page" class="relative flex flex-col items-center justify-center w-64 h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-600 dark:bg-gray-500 hover:bg-gray-50 dark:border-gray-400 dark:hover:border-gray-300 dark:hover:bg-gray-600">
                    <div id="dropzone-label" class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload Cover Page</span></p>
                        <p class="mb-2 text-sm text-center text-gray-500 dark:text-gray-400">or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 2048px)</p>
                    </div>
                    <img id="preview-image" src="" alt="Selected Image Preview" class="absolute inset-0 hidden object-cover w-full h-full rounded-lg" />
                    <input id="cover_page" name="cover_page" type="file" class="hidden" />
                </label>
                @if ($errors->has('cover_page'))
                    <span class="text-sm text-red-600">
                        {{ $errors->first('cover_page') }}
                    </span>
                @endif
            </div>

            <div class="w-full px-6 py-4 bg-white shadow-md sm:max-w-md sm:rounded-lg">
                @csrf

                <!-- Title -->
                <div class="mt-4">
                    <x-label for="title" value="{{ __('Title') }}" />
                    <x-input class="block w-full mt-1 text-gray-700" id="title" type="text" name="title" :value="old('title')"/>

                @if ($errors->has('title'))
                    <span class="text-sm text-red-600">
                        {{ $errors->first('title') }}
                    </span>
                @endif
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <x-label for="description" value="{{ __('Description') }}" />
                    <textarea class="block w-full h-[50px] md:h-[100px] lg:h-[100px] resize-none rounded border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700"
                     id="description" name="description" maxlength="50" placeholder="A brief description of your content helps your readers get a gist of what to expect in the main content" oninput="updateCountdown()">{{ old('description') }}</textarea>
                    <small id="description-countdown" class="flex justify-end text-sm">50 characters remaining</small>

                    @if ($errors->has('description'))
                        <span class="text-sm text-red-600">
                            {{ $errors->first('description') }}
                        </span>
                    @endif
                </div>

                <!-- Category -->
                <div class="mt-4">
                    <x-label for="category" value="{{ __('Category') }}" />
                    <select id="category" class="block w-full mt-1 text-gray-700" name="category">
                        <option>-----Select a category-----</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category'))
                        <span class="text-sm text-red-600">
                            {{ $errors->first('category') }}
                        </span>
                    @endif
                </div>

                <!-- Keywords -->
                <div class="mt-4">
                    <x-label for="keywords" value="{{ __('Keywords') }}" />
                    <x-input id="keywords" class="block w-full mt-1 text-gray-700" type="text" name="keywords" :value="old('keywords')" 
                                title="Write keywords that best describes your content to improve search for your content" 
                                placeholder="Enter keywords separated by commas" />

                    @if ($errors->has('keywords'))
                        <span class="text-sm text-red-600">
                            {{ $errors->first('keywords') }}
                        </span>
                    @endif
                </div>

                <!-- Chapter-wise -->
                <div class="mt-4">
                    <label for="is_chapter" class="inline-flex items-center">
                        <input id="is_chapter" type="checkbox" name="is_chapter" title="Only check if your content will be based on chapters" class="text-indigo-600 border-gray-500 rounded shadow-sm focus:border-indigo-400 focus:ring focus:ring-indigo-300 focus:ring-opacity-70">
                        <span class="ml-2 text-sm text-gray-700">{{ __('Chapter-wise') }}</span>
                    </label>

                    @if ($errors->has('is_chapter'))
                        <span class="text-sm text-red-600">
                            {{ $errors->first('is_chapter') }}
                        </span>
                    @endif
                </div>

                <div class="flex justify-center mt-4">
                    <x-button>
                        {{ __('Proceed to Create Content') }}
                    </x-button>
                </div>
            </div>
        </div>
    </form>

    <!-- JavaScript for updating the character count -->
    <script>
        function updateCountdown() {
            const textarea = document.getElementById('description');
            const countdown = document.getElementById('description-countdown');
            const maxLength = 50;
            const remaining = maxLength - textarea.value.length;
            countdown.textContent = `${remaining} characters remaining`;
        }

        // Initialize the countdown when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            updateCountdown();
        });
    </script>
    <script>
        const fileInput = document.getElementById('cover_page');
        const previewImage = document.getElementById('preview-image');
        const dropzoneLabel = document.getElementById('dropzone-label');

        fileInput.addEventListener('change', (event) => {
            const selectedFile = event.target.files[0];
            if (selectedFile) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    dropzoneLabel.classList.add('hidden');
                };
                reader.readAsDataURL(selectedFile);
            } else {
                previewImage.src = '';
                previewImage.classList.add('hidden');
                dropzoneLabel.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
