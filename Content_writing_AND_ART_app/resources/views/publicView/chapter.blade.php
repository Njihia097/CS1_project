<x-content-layout>
@section('content')
<div class="max-w-4xl p-6 mx-auto bg-white rounded-lg shadow-md">
    <div class="text-center">
        <h2 class="text-3xl font-bold">{{ $chapter->content->Title }}</h2>
        <h3 class="mt-2 text-2xl font-semibold">Chapter {{ $chapter->ChapterNumber }}: {{ $chapter->Title }}</h3>
    </div>
    <div class="mt-6 text-gray-700">
        <div id="content-container" class="text-gray-700"></div>
    </div>

    <livewire:reactions :model="$chapter"/>
    
    <!-- Comment section for preceding chapters -->
    <div class="mt-8">
        <livewire:comments :model="$chapter"/>
    </div>

    <!-- Related Content -->
    <div class="mt-8">
        <h3 class="text-2xl font-semibold">Related Content</h3>
        <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2">
            @foreach ($relatedByCategory as $content)
                @include('partials.content_card', ['content' => $content])
            @endforeach
            @foreach ($relatedByAuthor as $content)
                @include('partials.content_card', ['content' => $content])
            @endforeach
            @foreach ($relatedByKeywords as $content)
                @include('partials.content_card', ['content' => $content])
            @endforeach
        </div>
    </div>

    <!-- Related Chapters -->
    <div class="mt-8">
        <h3 class="text-2xl font-semibold">Related Chapters</h3>
        <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2">
            @foreach ($relatedChapters as $relatedChapter)
                <div class="flex flex-col items-center p-2 mb-4 bg-gray-200 border border-gray-400 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-200">
                    <div class="flex flex-col justify-between p-4 leading-normal">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Chapter {{ $relatedChapter->ChapterNumber }}: {{ $relatedChapter->Title }}</h5>
                        <p class="mb-3 font-normal text-gray-900">{{ Str::limit($relatedChapter->content_delta, 100) }}</p>
                        <a href="{{ route('publicView.chapter', [$relatedChapter->ChapterID]) }}" class="inline-block w-48 px-6 py-2 mt-4 text-sm font-semibold text-center text-white bg-black rounded hover:bg-gray-700">Read Chapter</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
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
