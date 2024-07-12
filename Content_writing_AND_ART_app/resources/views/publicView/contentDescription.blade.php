<x-content-layout :content="$content">
@section('content')

<div class="max-w-4xl p-6 mx-auto bg-white rounded-lg shadow-md">
    <div class="flex flex-col items-center space-y-4">
        <div class="text-center">
            <h2 class="text-3xl font-bold">{{ $content->Title}}</h2>
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
            <p class="text-gray-700">by {{ $content->author->name}}</p>
        </div>
    </div>
    <div class="mt-6 text-gray-700">
        <p class="px-4 mt-2">{{ $content->Description }}</p>
    </div>
    <div class="mt-6 text-center">
        <a href="{{ route('publicView.startReading', ['id' => $content->ContentID]) }}" class="px-6 py-3 text-white bg-blue-600 rounded-full hover:bg-blue-700">Start Reading</a>
    </div>
</div>
@endsection

</x-content-layout>