<!-- adminManageContent.blade.php -->

<x-admin-layout : artistCount="$artistCount" contentCount="$contentCount">
    @section('content')
    <div class="max-w-4xl mx-auto mt-8 text-white">
        <div class="mb-2">
            <h2 class="text-lg font-bold tracking-widest text-gray-100 uppercase">
                Manage Flagged Content
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
                <div class="relative inline-block text-left">
    <button type="button"
        class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
        id="options-menu" aria-haspopup="true" aria-expanded="true">
        Status
        <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </button>

    <div
        class="absolute right-0 hidden w-56 mt-2 text-white origin-top-right bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
        id="checkbox-list">
        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <!-- ... -->
        </div>
    </div>
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
                    @if ($contents->count() > 0)
                        @foreach ($contents as $content)
                            <tr class="items-center bg-gray-800 border-b border-gray-700 hover:bg-gray-700" data-status="{{ $content->Status }}">
                                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                                    {{ $loop->iteration }}</th>
                                <td class="px-6 py-4">{{ $content->Title }}</td>
                                <td class="w-full px-6 py-4">{{ Str::limit($content->Description, 200) }}</td>
                                <td
                                    class="px-6 py-4 {{ $content->Status == 'suspended' ? 'text-yellow-400' : ($content->Status == 'flagged' ? 'text-red-400' : ($content->Status == 'approved' ? 'text-green-400' : 'bg-gray-400')) }}">
                                    {{ ucfirst($content->Status) }}</td>
                                <td class="flex gap-2 px-6 py-4">
                                    <a href="{{ route('admin.contentDetailsView', ['id' => $content->ContentID]) }}"
                                        class="font-medium text-blue-500 view-btn hover:underline">View</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-100">No Flagged contents were found!!
                            </td>
                        </tr>
                    @endif
                </tbody>

            </table>
        </div>
    </div>
    <script>
        document.querySelectorAll('.form-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const status = this.id.split('-')[1];
                const rows = document.querySelectorAll(`#contentTable tr[data-status="${status}"]`);

                rows.forEach(row => {
                    if (this.checked) {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
        document.getElementById('options-menu').addEventListener('click', function() {
        const checkboxList = document.getElementById('checkbox-list');
        checkboxList.classList.toggle('hidden');
    });

    window.addEventListener('click', function(e) {
        if (!document.getElementById('options-menu').contains(e.target)) {
            document.getElementById('checkbox-list').classList.add('hidden');
        }
    });
    </script>

    @endsection
</x-admin-layout>