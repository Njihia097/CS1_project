<!-- startReading.blade.php -->

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

            <livewire:reactions :model="$firstChapter"/>

            <div class="mt-8">
                <livewire:comments :model="$firstChapter"/>
            </div>
        @else
            <div class="mt-6 text-gray-700">
                <div id="content-container" class="text-gray-700"></div>
            </div>

            <livewire:reactions :model="$content"/>

            <div class="mt-8">
                <livewire:comments :model="$content"/>
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
    <div>
    <!-- Recommendations Section -->
    <div class="mt-8 ml-4">
        <h3 class="mr-4 text-2xl font-semibold">You might also like:</h3>
        <div class="mt-4 ml-4">
            
            <!-- Recommendations by Category -->
            @if ($relatedByCategory->isNotEmpty())
                <h4 class="text-xl font-semibold">Related by Category</h4>
                <div class="mt-2 row">
                    @foreach ($relatedByCategory as $relatedContent)
                        @include('partials.content_card', ['content' => $relatedContent])
                    @endforeach
                </div>
            @endif

            <!-- Recommendations by Author -->
            @if ($relatedByAuthor->isNotEmpty())
                <h4 class="text-xl font-semibold">More from {{ $content->author->name }}</h4>
                <div class="mt-2 row">
                    @foreach ($relatedByAuthor as $relatedContent)
                        @include('partials.content_card', ['content' => $relatedContent])
                    @endforeach
                </div>
            @endif

            <!-- Recommendations by Keywords -->
            @if ($relatedByKeywords->isNotEmpty())
                <h4 class="text-xl font-semibold">Related by Keywords</h4>
                <div class="mt-2 row">
                    @foreach ($relatedByKeywords as $relatedContent)
                        @include('partials.content_card', ['content' => $relatedContent])
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>

        </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        const quill = new Quill('#content-container', {
            theme: 'snow',
            readOnly: true,
            modules: {
                toolbar: false
            }
        });

        const contentDelta = {!! json_encode($combinedContentDelta) !!};
        quill.setContents(contentDelta);
    </script>
@endsection
</x-content-layout>
