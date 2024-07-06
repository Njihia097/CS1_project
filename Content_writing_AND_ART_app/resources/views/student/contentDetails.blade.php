<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        /* Add your custom styles here */
        .tab-content {
            padding-top: 20px;
        }
    </style>
</head>
<body>
<x-app-layout>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="cover_image.jpg" class="card-img-top" alt="Cover Image" id="coverImage">
                    <div class="text-center card-body">
                        <button class="btn btn-primary" onclick="document.getElementById('coverImageInput').click()">Change Cover</button>
                        <input type="file" id="coverImageInput" style="display:none" accept="image/*" onchange="previewCoverImage(event)">
                    </div>
                </div>
                <button class="mt-3 btn btn-warning w-100">View as reader</button>
            </div>
            <div class="col-md-9">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-story-details-tab" data-bs-toggle="tab" data-bs-target="#nav-story-details" type="button" role="tab">Story Details</button>
                        <button class="nav-link" id="nav-table-of-contents-tab" data-bs-toggle="tab" data-bs-target="#nav-table-of-contents" type="button" role="tab">Table of Contents</button>
                        <button class="nav-link" id="nav-story-notes-tab" data-bs-toggle="tab" data-bs-target="#nav-story-notes" type="button" role="tab">Story Notes</button>
                    </div>
                </nav>
                <div class="w-full px-6 py-4 bg-white shadow-md tab-content sm:rounded-lg" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-story-details" role="tabpanel">
                        <form id="storyForm" action="/saveStoryDetails" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="cover_image" id="coverImageData">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Untitled Story">
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
                            <div class="flex justify-center mt-4">
                                <button type="submit" onclick="saveDetails()" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 disabled:opacity-50">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-table-of-contents" role="tabpanel">
                        <button class="mb-3 btn btn-primary">+ New Part</button>
                        <ul class="list-group" id="tableOfContents">
                            <!-- List of parts will be inserted here dynamically -->
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="nav-story-notes" role="tabpanel">
                        <!-- Story Notes Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
       

        function previewCoverImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('coverImage');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function saveDetails() {
            // Save the details using AJAX or form submission
            alert('Details saved!');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Load Table of Contents dynamically
            const tableOfContents = [
                {title: 'Part 1', date: 'May 14, 2024', views: 3, comments: 0, likes: 0},
                {title: 'Part 2', date: 'May 14, 2024', views: 2, comments: 0, likes: 0}
            ];
            const tableOfContentsContainer = document.getElementById('tableOfContents');
            tableOfContents.forEach(part => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                listItem.innerHTML = `
                    <div>
                        <h5 class="mb-0">Greatness</h5>
                        <small>Draft - 07/08/2024</small>
                    </div>
                    <div>
                        <span class="badge bg-primary rounded-pill">4 <i class="bi bi-eye"></i></span>
                        <span class="badge bg-secondary rounded-pill">6 <i class="bi bi-star"></i></span>
                        <span class="badge bg-secondary rounded-pill">8 <i class="bi bi-chat"></i></span>
                    </div>
                `;
                tableOfContentsContainer.appendChild(listItem);
            });
        });
    </script>
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
</body>
</html>