<x-editor-layout>
    @section('content')
<!-- component -->
<div class="max-w-4xl mx-auto mt-8 text-white">
    <div class="mb-2">
        <h2 class="text-lg font-bold tracking-widest text-gray-100 uppercase">
            Manage Content Categories
        </h2>
    </div>

    <div class="relative overflow-x-auto bg-gray-800 shadow-md sm:rounded-lg">
                <!-- Success and Error Messages -->
                <div id="message" class="fixed hidden p-4 rounded shadow-lg z-1000" role="alert"></div>

        <div class="flex items-center justify-between p-4">

            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="text" id="searchInput" class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5" placeholder="Search categories...">
            </div>

            <!-- Add New Category Button -->
            <a href="" id="addCategoryBtn" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:no-underline hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                + Add New Category
            </a>
        </div>

        <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs text-gray-300 uppercase bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">#no</th>
                    <th scope="col" class="px-6 py-3">Category Name</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3"><span class="sr-only">Action</span></th>
                </tr>
            </thead>
            <tbody id="categoryTable">
                @php
                    $start = ($categories->currentPage() - 1) * $categories->perPage();
                @endphp
                @forelse ($categories as $category)
                <tr class="bg-gray-800 border-b border-gray-700 hover:bg-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">{{ $loop->iteration + $start }}</th>
                    <td class="px-6 py-4">{{ $category->CategoryName }}</td>
                    <td class="w-full px-6 py-4">{{ Str::limit($category->Description, 200)}} </td>
                    <td class="flex justify-between gap-2 px-6 py-4 text-right">
                        <a href="#" class="font-medium text-blue-500 edit-btn hover:underline" data-id="{{ $category->CategoryID }}" data-name="{{ $category->CategoryName }}" data-description="{{ $category->Description }}">Edit</a>
                        <a href="#" class="font-medium text-red-500 delete-btn hover:underline" data-id="{{ $category->CategoryID }}">Delete</a>
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
            {{ $categories->links('vendor.pagination.tailwind') }}
        </div>
    </div>



        <!-- Add Modal -->
    <div id="addOverlay" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50"></div>
    <div id="addModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="p-6 bg-gray-800 rounded-lg shadow-lg w-96">
            <h2 class="mb-4 text-xl font-bold">Add New Category</h2>
            <form id="addForm">
                @csrf
                <div class="mb-4">
                    <label for="addCategoryName" class="block mb-2">Category Name</label>
                    <input type="text" id="addCategoryName" class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <span id="addCategoryNameError" class="text-sm text-red-500"></span>
                </div>
                <div class="mb-4">
                    <label for="addCategoryDescription" class="block mb-2">Description</label>
                    <textarea id="addCategoryDescription" class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                    <span id="addCategoryDescriptionError" class="text-sm text-red-500"></span>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelAdd" class="px-4 py-2 mr-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Cancel</button>
                    <button type="button" id="confirmAdd" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Add Category</button>
                </div>
            </form>
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
                    <span id="editCategoryNameError" class="text-sm text-red-500"></span>
                </div>
                <div class="mb-4">
                    <label for="editCategoryDescription" class="block mb-2">Description</label>
                    <textarea id="editCategoryDescription" class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                    <span id="editCategoryDescriptionError" class="text-sm text-red-500"></span>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelEdit" class="px-4 py-2 mr-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Cancel</button>
                    <button type="button" id="confirmEdit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Confirm Edit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteOverlay" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50"></div>
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="p-6 bg-gray-800 rounded-lg shadow-lg w-96">
            <h2 class="mb-4 text-xl font-bold">Confirm Delete</h2>
            <p class="mb-4">Are you sure you want to delete this category?</p>
            <div class="flex justify-end">
                <button type="button" id="cancelDelete" class="px-4 py-2 mr-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-700">Cancel</button>
                <button type="button" id="confirmDelete" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700">Delete</button>
            </div>
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

            // Add Modal Elements
            const addOverlay = document.getElementById('addOverlay');
            const addModal = document.getElementById('addModal');
            const addForm = document.getElementById('addForm');
            const addCategoryName = document.getElementById('addCategoryName');
            const addCategoryDescription = document.getElementById('addCategoryDescription');
            const cancelAdd = document.getElementById('cancelAdd');
            const confirmAdd = document.getElementById('confirmAdd');
            const addCategoryBtn = document.getElementById('addCategoryBtn');

            // Delete Modal Elements
            const deleteOverlay = document.getElementById('deleteOverlay');
            const deleteModal = document.getElementById('deleteModal');
            const cancelDelete = document.getElementById('cancelDelete');
            const confirmDelete = document.getElementById('confirmDelete');
            let categoryIdToDelete = null;

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

            // Utility function to display messages
            function displayMessage(type, message) {
                const messageDiv = document.getElementById('message');
                messageDiv.className = `fixed p-4 rounded shadow-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
                messageDiv.textContent = message;
                messageDiv.classList.remove('hidden');
                setTimeout(() => {
                    messageDiv.classList.add('hidden');
                }, 3000);
            }

            // Clear error messages
            function clearErrors() {
                document.querySelectorAll('.text-red-500').forEach(error => {
                    error.textContent = '';
                });
            }

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

            // Handle edit category
            confirmEdit.addEventListener('click', function () {
                clearErrors();
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

                        displayMessage('success', 'Category updated successfully!');
                    } else if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            document.getElementById(`edit${key}Error`).textContent = data.errors[key][0];
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    displayMessage('error', 'Failed to update category!');
                });
            });

            addCategoryBtn.addEventListener('click', function () {
                event.preventDefault();
                addOverlay.classList.remove('hidden');
                addModal.classList.remove('hidden');
            });

            cancelAdd.addEventListener('click', function () {
                addOverlay.classList.add('hidden');
                addModal.classList.add('hidden');
            });

            // Handle add category
            confirmAdd.addEventListener('click', function () {
                clearErrors();
                const name = addCategoryName.value;
                const description = addCategoryDescription.value;

                fetch(`/editor/content-categories`, {
                    method: 'POST',
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
                        // Append new row to the table
                        const newRow = document.createElement('tr');
                        newRow.classList.add('bg-gray-800', 'border-b', 'border-gray-700', 'hover:bg-gray-700');
                        newRow.innerHTML = `
                            <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">${data.category.id}</th>
                            <td class="px-6 py-4">${data.category.CategoryName}</td>
                            <td class="w-full px-6 py-4">${data.category.Description}</td>
                            <td class="flex justify-between gap-2 px-6 py-4 text-right">
                                <a href="#" class="font-medium text-blue-500 edit-btn hover:underline" data-id="${data.category.CategoryID}" data-name="${data.category.CategoryName}" data-description="${data.category.Description}">Edit</a>
                                <a href="#" class="font-medium text-red-500 hover:underline">Delete</a>
                            </td>
                        `;
                        categoryTable.appendChild(newRow);

                        addOverlay.classList.add('hidden');
                        addModal.classList.add('hidden');

                        // Reset form fields
                        addCategoryName.value = '';
                        addCategoryDescription.value = '';

                        displayMessage('success', 'Category added successfully!');
                    } else if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            document.getElementById(`add${key}Error`).textContent = data.errors[key][0];
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    displayMessage('error', 'Failed to add category!');
                });
            });

            // Delete button click event
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    categoryIdToDelete = this.dataset.id;
                    deleteOverlay.classList.remove('hidden');
                    deleteModal.classList.remove('hidden');
                });
            });

            // Cancel delete button click event
            cancelDelete.addEventListener('click', function () {
                deleteOverlay.classList.add('hidden');
                deleteModal.classList.add('hidden');
                categoryIdToDelete = null;
            });

            // Confirm delete button click event
            confirmDelete.addEventListener('click', function () {
                if (!categoryIdToDelete) return;

                fetch(`/editor/content-categories/${categoryIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the deleted category row from the table
                        const row = document.querySelector(`.delete-btn[data-id='${categoryIdToDelete}']`).closest('tr');
                        row.remove();

                        deleteOverlay.classList.add('hidden');
                        deleteModal.classList.add('hidden');
                        categoryIdToDelete = null;

                        displayMessage('success', 'Category deleted successfully!');
                    } else {
                        displayMessage('error', 'Failed to delete category!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    displayMessage('error', 'Failed to delete category!');
                });
            });

        });
    </script>
</div>
    @endsection
</x-editor-layout>