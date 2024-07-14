<x-student-layout>
@section('content')


<div class="flex justify-start p-4">
    <div class="relative inline-block text-left">
        <div>
            <button id="filterButton" type="button" class="inline-flex justify-center w-full p-2 text-sm font-medium text-gray-900 bg-gray-200 rounded-full hover:bg-gray-300 focus:outline-none">
                <i class="fa-solid fa-filter"></i>
                <p class="ml-2 text-gray-900 text-md">Filter</p>
            </button>
        </div>
        <div id="filterMenu" class="absolute left-0 z-50 hidden mt-2 origin-top-left bg-white border border-gray-200 rounded-md shadow-lg w-[32rem] max-w-sm sm:text-sm ring-1 ring-black ring-opacity-5 focus:outline-none">
            <form id="filterForm" class="grid grid-cols-3 gap-6 p-6" role="menu" aria-orientation="vertical" aria-labelledby="filterButton" method="GET" action=" {{ route('student.home.content') }} ">
                @csrf
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Type</h3>
                    <label class="flex items-center mt-2">
                        <input type="checkbox" name="types[]" value="All" class="w-4 h-4 text-gray-600 form-checkbox">
                        <span class="ml-2 text-gray-700">All</span>
                    </label>
                    <label class="flex items-center mt-2">
                        <input type="checkbox" name="types[]" value="Published" class="w-4 h-4 text-gray-600 form-checkbox">
                        <span class="ml-2 text-gray-700">Published</span>
                    </label>
                    <label class="flex items-center mt-2">
                        <input type="checkbox" name="types[]" value="Saved" class="w-4 h-4 text-gray-600 form-checkbox">
                        <span class="ml-2 text-gray-700">Draft</span>
                    </label>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Category</h3>
                    @foreach ($categories as $category)
                        <label class="flex items-center mt-2">
                            <input type="checkbox" name="categories[]" value="{{ $category->CategoryID}}" class="w-4 h-4 text-gray-600 form-checkbox">
                            <span class="ml-2 text-gray-700">{{ $category->CategoryName}}</span>
                        </label>
                    @endforeach
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-900">Content Structure</h3>
                    <label class="flex items-center mt-2">
                        <input type="checkbox" name="structures[]" value="Stand-alone" class="w-4 h-4 text-gray-600 form-checkbox">
                        <span class="ml-2 text-gray-700">Stand-alone</span>
                    </label>
                    <label class="flex items-center mt-2">
                        <input type="checkbox" name="structures[]" value="Chapter-wise" class="w-4 h-4 text-gray-600 form-checkbox">
                        <span class="ml-2 text-gray-700">Chapter-wise</span>
                    </label>
                </div>
                <button type="submit" class="inline-block px-6 py-2 mt-4 text-sm font-semibold text-center text-white bg-black rounded hover:bg-gray-700">Apply Filters</button>
            </form>
        </div>
    </div>
</div>



@foreach ($contents as $content)
<div class="grid grid-cols-1 gap-2 md:grid-cols-2 sm:flex sm:flex-col">
    <div class="flex flex-col items-center p-2 mb-4 bg-gray-200 border border-gray-400 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-200">
        <img class="object-cover w-full h-48 rounded-t-lg md:h-44 md:w-48 md:rounded-none md:rounded-l-lg" src="{{ asset('cover_images/' . $content->thumbnail) }}" alt="{{ $content->Title }}">
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $content->Title }}</h5>
            <p class="mb-3 font-normal text-gray-900">{{ Str::limit($content->Description, 100)}}</p>
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <i class="text-gray-900 fa-regular fa-comment"></i>
                    <span class="ml-1 text-gray-900">{{ $content->commentCount ?? 0 }}</span>
                </div>
                <div class="flex items-center">
                    <i class="text-gray-900 fa-regular fa-thumbs-up"></i>
                    <span class="ml-1 text-gray-900">{{ $content->thumbsUpCount ?? 0  }}</span>
                </div>
                <div class="flex items-center">
                    <i class="text-gray-900 fa-regular fa-thumbs-down"></i>
                    <span class="ml-1 text-gray-900">{{ $content->thumbsDownCount ?? 0 }}</span>
                </div>
                @if ($content->IsChapter)
                <div class="flex items-center">
                    <i class="fa-solid fa-list"></i>
                    <span class="ml-1 text-gray-900">{{ $content->chapterCount ?? 0 }}</span>
                </div>
                @endif
            </div>
            <a href="{{ route('student.contentDetails', ['content' => $content->ContentID]) }}" class="inline-block w-48 px-6 py-2 mt-4 text-sm font-semibold text-center text-white bg-black rounded hover:bg-gray-700">Content Details</a>
        </div>
    </div>
</div>
@endforeach


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterButton = document.getElementById('filterButton');
        const filterMenu = document.getElementById('filterMenu');

        filterButton.addEventListener('click', function () {
            filterMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!filterButton.contains(event.target) && !filterMenu.contains(event.target)) {
                filterMenu.classList.add('hidden');
            }
        });
    });
</script>
<!-- <script>
    document.getElementById('filterButton').addEventListener('click', function() {
        document.getElementById('filterMenu').classList.toggle('hidden');
    });
</script> -->




@endsection

</x-student-layout>