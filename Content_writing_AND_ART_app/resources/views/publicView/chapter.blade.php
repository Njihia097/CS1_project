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
        <livewire:comments :model="$chapter"/>
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
        const contentDelta = {!! json_encode($combinedChapterContentDelta) !!};
        quill.setContents(contentDelta);
    </script>
@endsection
</x-content-layout>
