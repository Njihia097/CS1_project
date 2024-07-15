<x-student-layout>
@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold">Reading List</h1>
    @foreach ($favorites as $favorite)
    <div class="flex flex-col items-center p-2 mb-4 bg-gray-200 border border-gray-400 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-200">
        <img class="object-cover w-full h-48 rounded-t-lg md:h-44 md:w-48 md:rounded-none md:rounded-l-lg" src="{{ asset('cover_images/' . $favorite->content->thumbnail) }}" alt="{{ $favorite->content->Title }}">
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $favorite->content->Title }}</h5>
            <p class="mb-3 font-normal text-gray-900">{{ Str::limit($favorite->content->Description, 100)}}</p>
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <i class="text-gray-900 fa-regular fa-comment"></i>
                    <span class="ml-1 text-gray-900">{{ $favorite->content->comments->count() }}</span>
                </div>
                <div class="flex items-center">
                    <i class="text-gray-900 fa-regular fa-thumbs-up"></i>
                    <span class="ml-1 text-gray-900">{{ $favorite->content->reactions->where('type', 'thumbs_up')->count() }}</span>
                </div>
                <div class="flex items-center">
                    <i class="text-gray-900 fa-regular fa-thumbs-down"></i>
                    <span class="ml-1 text-gray-900">{{ $favorite->content->reactions->where('type', 'thumbs_down')->count() }}</span>
                </div>
                @if ($favorite->content->IsChapter)
                <div class="flex items-center">
                    <i class="fa-solid fa-list"></i>
                    <span class="ml-1 text-gray-900">{{ $favorite->content->chapters->count() }}</span>
                </div>
                @endif
            </div>
            <a href="{{ route('publicView.startReading', ['id' => $favorite->ContentID]) }}" class="inline-block w-48 px-6 py-2 mt-4 text-sm font-semibold text-center text-white bg-black rounded hover:bg-gray-700">Continue Reading</a>
        </div>
    </div>
    @endforeach
</div>
@endsection
</x-student-layout>
