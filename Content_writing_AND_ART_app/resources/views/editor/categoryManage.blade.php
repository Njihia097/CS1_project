<x-editor-layout>
    @section('content')
<!-- component -->
<div class="max-w-4xl mx-auto mt-8 text-white">

    <div class="relative overflow-x-auto bg-gray-800 shadow-md sm:rounded-lg">
        <div class="p-4">
            <label for="searchInput" class="sr-only">Search</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="searchInput" class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5" placeholder="Search categories...">
            </div>
        </div>
        <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs text-gray-300 uppercase bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">#no</th>
                    <th scope="col" class="px-6 py-3">CategoryName</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3"><span class="sr-only">Action</span></th>
                </tr>
            </thead>
            <tbody id="categoryTable">
                @forelse ($categories as $category)
                <tr class="bg-gray-800 border-b border-gray-700 hover:bg-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">{{ $loop->iteration }}</th>
                    <td class="px-6 py-4">{{ $category->CategoryName }}</td>
                    <td class="w-full px-6 py-4">{{ Str::limit($category->Description, 200)}} </td>
                    <td class="flex justify-between gap-2 px-6 py-4 text-right">
                        <a href="#" class="font-medium text-blue-500 edit-btn hover:underline" data-id="{{ $category->CategoryID }}" data-name="{{ $category->CategoryName }}" data-description="{{ $category->Description }}">Edit</a>
                        <a href="#" class="font-medium text-red-500 hover:underline">Delete</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <!-- Pagination Links -->
        <div class="p-4">
            {{ $categories->links() }}
        </div>
    </div>
    <!-- Edit Modal -->
    <div id="editOverlay" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50"></div>
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="p-6 bg-gray-800 rounded-lg shadow-lg w-96">
            <h2 class="mb-4 text-xl font-bold">Edit Category</h2>
            <form id="editForm">
                @csrf
                <input type="hidden" id="editCategoryId">
                <div class="mb-4">
                    <label for="editCategoryName" class="block mb-2">Category Name</label>
                    <input type="text" id="editCategoryName" class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div class="mb-4">
                    <label for="editCategoryDescription" class="block mb-2">Description</label>
                    <textarea id="editCategoryDescription" class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelEdit" class="px-4 py-2 mr-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Cancel</button>
                    <button type="button" id="confirmEdit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Confirm Edit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const categoryTable = document.getElementById('categoryTable');
            const rows = categoryTable.querySelectorAll('tr');
            const editOverlay = document.getElementById('editOverlay');
            const editModal = document.getElementById('editModal');
            const editForm = document.getElementById('editForm');
            const editCategoryId = document.getElementById('editCategoryId');
            const editCategoryName = document.getElementById('editCategoryName');
            const editCategoryDescription = document.getElementById('editCategoryDescription');
            const cancelEdit = document.getElementById('cancelEdit');
            const confirmEdit = document.getElementById('confirmEdit');

            searchInput.addEventListener('keyup', function () {
                const searchTerm = searchInput.value.trim().toLowerCase();

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const categoryName = cells[0].textContent.trim().toLowerCase();
                    const description = cells[1].textContent.trim().toLowerCase();

                    if (categoryName.includes(searchTerm) || description.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const description = this.getAttribute('data-description');

                    editCategoryId.value = id;
                    editCategoryName.value = name;
                    editCategoryDescription.value = description;

                    editOverlay.classList.remove('hidden');
                    editModal.classList.remove('hidden');
                });
            });

            cancelEdit.addEventListener('click', function () {
                editOverlay.classList.add('hidden');
                editModal.classList.add('hidden');
            });

            confirmEdit.addEventListener('click', function () {
                const id = editCategoryId.value;
                const name = editCategoryName.value;
                const description = editCategoryDescription.value;

                fetch(`/editor/content-categories/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        CategoryName: name,
                        Description: description
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the table row with new data
                        const row = document.querySelector(`.edit-btn[data-id='${id}']`).closest('tr');
                        row.querySelectorAll('td')[0].textContent = name;
                        row.querySelectorAll('td')[1].textContent = description;
                        editOverlay.classList.add('hidden');
                        editModal.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });

        });
    </script>
</div>
    @endsection
</x-editor-layout>