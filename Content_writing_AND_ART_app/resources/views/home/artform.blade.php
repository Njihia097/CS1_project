<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artwork sale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

   <div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-5">Create Content</h2>
    <form action="{{ route('artists.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="w-full px-6 py-4 bg-white shadow-md sm:max-w-md sm:rounded-lg">
            <!-- Title -->
            <div class="mt-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="block w-full mt-1 text-gray-700 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required/>
            </div>

            <!-- Description -->
            <div class="mt-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" class="block w-full h-[50px] md:h-[100px] lg:h-[100px] resize-none rounded border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700" maxlength="50" placeholder="A brief description of your content helps your readers get a gist of what to expect in the main content" oninput="updateCountdown()" required></textarea>
                <small id="description-countdown" class="flex justify-end text-sm">50 characters remaining</small>
            </div>

            <!-- Dimensions -->
            <div class="mt-4">
                <label for="width" class="block text-sm font-medium text-gray-700">Width (in inches)</label>
                <input type="number" id="width" name="width" class="block w-full mt-1 text-gray-700 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required/>
            </div>
            <div class="mt-4">
                <label for="height" class="block text-sm font-medium text-gray-700">Height (in inches)</label>
                <input type="number" id="height" name="height" class="block w-full mt-1 text-gray-700 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required/>
            </div>

            <!-- Upload Artwork -->
            <div class="mt-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Upload Artwork</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
            </div>

            <!-- Price -->
            <div class="mt-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" id="price" name="price" class="block w-full mt-1 text-gray-700 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter price" step="0.01" required/>
            </div>

            <!-- Keywords -->
            <div class="mt-4">
                <label for="keywords" class="block text-sm font-medium text-gray-700">Keywords</label>
                <input type="text" id="keywords" name="keywords" class="block w-full mt-1 text-gray-700 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter keywords separated by commas" required/>
            </div>

            <!-- Medium -->
            <div class="mt-4">
                <label for="medium" class="block text-sm font-medium text-gray-700">Medium</label>
                <input type="text" id="medium" name="medium" class="block w-full mt-1 text-gray-700 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required/>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Proceed to Post Art
                </button>
            </div>

            
        </div>
    </form>
</div>


</body>
</html>
