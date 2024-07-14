<x-editor-layout>
    @section('content')
    <div class="max-w-4xl mx-auto mt-8 text-white">
        <a href="{{ route('editor.showManageContent') }}" class="text-blue-500 hover:underline">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back
        </a>
        <div class="p-6 mt-4 bg-gray-800 rounded-lg shadow-lg">
            <!-- Success and Error Messages -->
            <div id="message" class="fixed hidden p-4 rounded shadow-lg z-1000" role="alert"></div>
            <div class="flex items-start justify-between">
                <div>
                    <img src="{{ $content->thumbnail ? asset('cover_images/' . $content->thumbnail) : 'img/banner-3.jpg' }}" alt="{{ $content->Title }}" class="object-cover w-32 h-32 rounded-lg">
                    <h2 class="mt-4 text-2xl font-bold">{{ $content->Title }}</h2>
                    <p class="mt-2">By: {{ $content->author->name }}</p>
                </div>
                <div class="text-right">
                    <span id="content-status" class="px-4 py-2 text-sm font-bold {{ $content->Status == 'pending' ? 'bg-yellow-400' : ($content->Status == 'flagged' ? 'bg-red-400' : ($content->Status == 'approved' ? 'bg-green-400' : 'bg-gray-400')) }} rounded">{{ $content->Status }}</span>
                </div>
            </div>
            <div class="mt-4">
                <p>{{ $content->Description }}</p>
            </div>
            <div class="mt-6">
                @if ($content->IsChapter && $content->chapters->where('IsPublished', 1)->count() > 0)
                    <h3 class="text-xl font-bold">Published Chapters</h3>
                    <div class="mt-4 space-y-4">
                        @foreach ($content->chapters->where('IsPublished', 1) as $chapter)
                            <div class="p-4 bg-gray-700 rounded-lg shadow">
                                <h4 class="text-lg font-bold">{{ $chapter->Title }}</h4>
                                <p class="mt-2"></p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="flex justify-end mt-6 space-x-4">
                <button id="approve-btn" class="px-4 py-2 rounded font-bold text-white {{ $content->Status == 'approved' ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-700' }}" {{ $content->Status == 'approved' ? 'disabled' : '' }} data-id="{{ $content->ContentID }}">Approve</button>
                <button id="flag-btn" class="px-4 py-2 rounded font-bold text-white {{ $content->Status == 'flagged' ? 'bg-gray-400 cursor-not-allowed' : 'bg-red-500 hover:bg-red-700' }}" {{ $content->Status == 'flagged' ? 'disabled' : '' }} data-id="{{ $content->ContentID }}">Flag</button>
                <a href="{{ route('publicView.startReading', ['id' => $content->ContentID])}}" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:no-underline hover:bg-blue-700">Review</a>
            </div>
        </div>
    </div>

    <script>
        // Approve and Flag button click events
        document.getElementById('approve-btn').addEventListener('click', function () {
            const contentId = this.dataset.id;
            updateContentStatus(contentId, 'approved');
        });

        document.getElementById('flag-btn').addEventListener('click', function () {
            const contentId = this.dataset.id;
            updateContentStatus(contentId, 'flagged');
        });

        function updateContentStatus(contentId, status) {
            fetch(`/editor/content/${contentId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the status label
                    const statusLabel = document.getElementById('content-status');
                    statusLabel.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    statusLabel.className = `px-4 py-2 text-sm font-bold ${status == 'approved' ? 'bg-green-400' : 'bg-red-400'} rounded`;

                    // Update the buttons
                    const approveBtn = document.getElementById('approve-btn');
                    const flagBtn = document.getElementById('flag-btn');

                    if (status === 'approved') {
                        approveBtn.className = 'px-4 py-2 rounded font-bold text-white bg-gray-400 cursor-not-allowed';
                        approveBtn.disabled = true;
                        flagBtn.className = 'px-4 py-2 rounded font-bold text-white bg-red-500 hover:bg-red-700';
                        flagBtn.disabled = false;
                    } else if (status === 'flagged') {
                        flagBtn.className = 'px-4 py-2 rounded font-bold text-white bg-gray-400 cursor-not-allowed';
                        flagBtn.disabled = true;
                        approveBtn.className = 'px-4 py-2 rounded font-bold text-white bg-green-500 hover:bg-green-700';
                        approveBtn.disabled = false;
                    }

                    displayMessage('success', `Content ${status} successfully!`);
                } else {
                    displayMessage('error', `Failed to ${status} content!`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                displayMessage('error', `Failed to ${status} content!`);
            });
        }

        function displayMessage(type, message) {
            const messageDiv = document.getElementById('message');
            messageDiv.className = `fixed p-4 rounded shadow-lg z-1000 ${type == 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
            messageDiv.textContent = message;
            messageDiv.classList.remove('hidden');
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        }
    </script>
    @endsection
</x-editor-layout>
