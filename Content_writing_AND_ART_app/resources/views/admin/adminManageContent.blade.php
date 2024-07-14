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
                    @if ($flaggedContents->count() > 0)
                        @foreach ($flaggedContents as $content)
                            <tr class="items-center bg-gray-800 border-b border-gray-700 hover:bg-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">{{ $loop->iteration }}</th>
                                <td class="px-6 py-4">{{ $content->Title }}</td>
                                <td class="w-full px-6 py-4">{{ Str::limit($content->Description, 200) }}</td>
                                <td class="px-6 py-4 {{ $content->Status == 'pending' ? 'text-yellow-400' : ($content->Status == 'flagged' ? 'text-red-400' : ($content->Status == 'approved' ? 'text-green-400' : 'bg-gray-400')) }}">{{ ucfirst($content->Status) }}</td>
                                <td class="flex gap-2 px-6 py-4">
                                    <a href="{{ route('admin.contentDetailsView', ['id' => $content->ContentID]) }}" class="font-medium text-blue-500 view-btn hover:underline">View</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-100">No Flagged contents were found!!</td>
                        </tr>
                    @endif
                </tbody>

            </table>
        </div>
    </div>
    @endsection
</x-admin-layout>
