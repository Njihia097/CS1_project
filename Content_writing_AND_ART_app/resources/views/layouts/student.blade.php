<x-app-layout>

<div class="relative w-full mt-4 overflow-hidden rounded shadow-2xl">
    <div class="relative w-full h-64 overflow-hidden bg-blue-600 top">
        <img src="https://images.unsplash.com/photo-1503264116251-35a269479413?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80" alt="" class="absolute z-0 object-cover object-center w-full h-full bg">
        <div class="relative flex flex-col items-center justify-center h-full text-white bg-black bg-opacity-50">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80" class="object-cover w-24 h-24 rounded-full">
            <h1 class="text-2xl font-semibold">Antonia Howell</h1>
            <h4 class="text-sm font-semibold">Joined Since '19</h4>
            <div class="flex justify-around w-full mt-4 space-x-4 text-center">
                <div>
                    <h2 class="text-xl font-bold">1</h2>
                    <span class="text-gray-100">Stories + Poems</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold">0</h2>
                    <span class="text-gray-100">Art Works</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold">0</h2>
                    <span class="text-gray-100">Reading List</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border-t border-gray-200">
        <nav class="flex justify-around text-center">
            <a href=" {{ route('student.home.about')}} " class="py-4 text-gray-600 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600 active-link">About</a>
            <a href=" {{ route('student.home.readingList')}} " class="py-4 text-gray-600 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600">Reading List</a>
            <a href=" {{ route('student.home.stories')}} " class="py-4 text-gray-600 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600">Stories</a>
            <a href=" {{ route('student.home.artwork')}} " class="py-4 text-gray-600 border-b-2 border-transparent hover:text-blue-600 hover:border-blue-600">Artwork</a>
        </nav>
    </div>
</div>



    <div class="pt-4">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('nav a');
            const currentUrl = window.location.href;

            // Remove active-link class from all links
            links.forEach(link => link.classList.remove('active-link'));

            // Add active-link class to the current link based on URL
            links.forEach(link => {
                if (link.href === currentUrl) {
                    link.classList.add('active-link');
                }
            });
        });
    </script>

</x-app-layout>
