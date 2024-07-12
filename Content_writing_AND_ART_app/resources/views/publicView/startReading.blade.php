<x-content-layout :content="$content">
@section('content')
    <div class="max-w-4xl p-6 mx-auto bg-white rounded-lg shadow-md">
        <div class="text-center">
            <h2 class="text-3xl font-bold">{{ $content->Title }}</h2>
        </div>

        @if ($content->IsChapter && isset($firstChapter))
            <div class="mt-6">
                <h3 class="text-2xl font-semibold">Chapter 1: {{ $firstChapter->Title }}</h3>
                <div id="content-container" class="mt-4 text-gray-700"></div>
            </div>
        @else
            <div class="mt-6 text-gray-700">
                <div id="content-container" class="text-gray-700"></div>
            </div>
        @endif

        @if ($content->IsChapter && $content->chapters->count() > 1)
            <div class="mt-6">
                <h4 class="text-xl font-semibold">Chapters:</h4>
                <ul class="mt-2">
                    @foreach ($content->chapters as $chapter)
                        <li><a href="{{ route('publicView.chapter', ['id' => $chapter->ChapterID]) }}" class="text-blue-600 hover:underline">{{ $chapter->Title }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // Initialize Quill editor in read-only mode
        const quill = new Quill('#content-container', {
            theme: 'snow',
            readOnly: true,
            modules: {
                toolbar: false // Hide toolbar in read-only mode
            }
        });

        // Set the content delta
        const contentDelta = {!! json_encode($combinedContentDelta) !!};
        quill.setContents(contentDelta);
    </script>
@endsection
</x-content-layout>
