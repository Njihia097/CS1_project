<x-editor-layout>
    @section('content')
    <div class="max-w-4xl mx-auto mt-8 text-white">
        <div class="mb-2">
            <h2 class="text-lg font-bold tracking-widest text-gray-100 uppercase">
                Manage Content
            </h2>
        </div>

        <div class="relative overflow-x-auto bg-gray-800 shadow-md sm:rounded-lg">
            <!-- Success and Error Messages -->
            <div id="message" class="fixed hidden p-4 rounded shadow-lg z-1000" role="alert"></div>

            <div class="flex items-center justify-between p-4">
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="searchInput"
                        class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5"
                        placeholder="Search content...">
                </div>
            </div>

            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs text-gray-300 uppercase bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">#no</th>
                        <th scope="col" class="px-6 py-3">Content Name</th>
                        <th scope="col" class="px-6 py-3">Description</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody id="contentTable" class="items-center">
                    @foreach ($contents as $content)
                                        <tr class="items-center bg-gray-800 border-b border-gray-700 hover:bg-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                                                {{ $loop->iteration }}
                                            </th>
                                            <td class="px-6 py-4">{{ $content->Title }}</td>
                                            <td class="w-full px-6 py-4">{{ Str::limit($content->Description, 200) }}</td>
                                            <td class="px-6 py-4
                        {{ $content->Status == 'pending' ? 'text-yellow-400' :
                            ($content->Status == 'flagged' ? 'text-red-400' :
                                ($content->Status == 'approved' ? 'text-green-400' :
                                    ($content->Status == 'suspended' ? 'text-orange-400' :
                                        'bg-gray-400'))) }}">
                                                {{ ucfirst($content->Status) }}
                                            </td>

                                            <td class="flex gap-2 px-6 py-4">
                                                <a href="{{ route('editor.displayContentDetails', ['id' => $content->ContentID]) }}"
                                                    class="font-medium text-blue-500 view-btn hover:underline">View</a>
                                            </td>
                                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewOverlay" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50"></div>
    <div id="viewModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="p-6 bg-gray-800 rounded-lg shadow-lg w-96">
            <h2 class="mb-4 text-xl font-bold">Content Details</h2>
            <div id="viewContentDetails"></div>
            <div class="flex justify-end mt-4">
                <button type="button" id="closeView"
                    class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Close</button>
            </div>
        </div>
    </div>
    <script>
        // Approve and Flag button click events
        document.querySelectorAll('.approve-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const contentId = this.dataset.id;
                updateContentStatus(contentId, 'approved');
            });
        });

        document.querySelectorAll('.flag-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const contentId = this.dataset.id;
                updateContentStatus(contentId, 'flagged');
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            window.Echo.channel('content-status')
                .listen('ContentStatusUpdated', (event) => {
                    const content = event.content;
                    displayMessage('info', `Content "${content.Title}" status updated to ${event.status}.`);
                });
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
                        const row = document.querySelector(`.approve-btn[data-id='${contentId}']`).closest('tr');
                        row.querySelector('td:nth-child(4)').textContent = status.charAt(0).toUpperCase() + status.slice(1);
                        row.querySelector('td:nth-child(4)').className = `px-6 py-4 ${status == 'approved' ? 'text-green-400' : 'text-red-400'}`;
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