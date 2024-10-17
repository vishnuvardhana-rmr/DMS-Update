@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 flex justify-center">
    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-center text-indigo-600">Create New Folder</h1>
        <form action="{{ route('admin.documents.store') }}" method="POST" class="space-y-6">
            @csrf
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Folder Name -->
            <div>
                <label for="folder_name" class="block text-sm font-medium text-gray-700">Folder Name</label>
                <input type="text" name="folder_name" id="folder_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <!-- Parent Folder Dropdown -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Select Parent Folder (optional)</label>
                <div class="relative mt-2">
                    <button type="button" id="dropdownButton" class="w-full border border-gray-300 p-4 rounded-lg shadow-sm flex justify-between items-center bg-white focus:outline-none">
                        <span id="selectedFolderText" class="text-gray-700">-- Select Parent Folder --</span>
                        <i class="fas fa-caret-down text-gray-500"></i>
                    </button>

                    <div id="dropdownMenu" class="absolute z-10 hidden w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                        <!-- Search Input -->
                        <input type="text" id="folderSearch" placeholder="Search folder..." class="block w-full border-b border-gray-300 p-2 focus:outline-none" onkeyup="filterFolders()">

                        <div class="border-b border-gray-200">
                            <input type="radio" name="parent_id" id="folder_none" value="" class="hidden" checked>
                            <label for="folder_none" class="cursor-pointer flex justify-between items-center p-4 hover:bg-indigo-100" onclick="selectFolder('None', '')">
                                <span class="text-sm font-medium text-gray-900">None</span>
                                <i class="fas fa-folder text-gray-500"></i> <!-- Optional folder icon -->
                            </label>
                        </div>

                        @foreach($folders as $folder)
                        <div class="border-b border-gray-200 folder-item">
                            <input type="radio" name="parent_id" id="folder_{{ $folder->id }}" value="{{ $folder->id }}" class="hidden">
                            <label for="folder_{{ $folder->id }}" class="cursor-pointer flex justify-between items-center p-4 hover:bg-indigo-100" onclick="selectFolder('{{ $folder->name }}', '{{ $folder->id }}')">
                                <span class="text-sm font-medium text-gray-900">{{ $folder->name }}</span>
                                <i class="fas fa-folder text-gray-500"></i>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 transition duration-150 ease-in-out">
                Create Folder
            </button>
        </form>
    </div>
</div>

<!-- JavaScript to handle dropdown -->
<script>
    document.getElementById('dropdownButton').addEventListener('click', function() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
    });

    // Function to select a folder
    function selectFolder(folderName, folderId) {
        document.getElementById('selectedFolderText').innerText = folderName || "None"; // Update text
        document.getElementById('folder_' + folderId).checked = true; // Check the radio button
        document.getElementById('folder_none').checked = (folderId === ''); // Handle the None option
        document.getElementById('dropdownMenu').classList.add('hidden'); // Hide dropdown after selection
    }

    // Filter folders based on search input
    function filterFolders() {
        const searchValue = document.getElementById('folderSearch').value.toLowerCase();
        const folderItems = document.querySelectorAll('.folder-item');

        folderItems.forEach(item => {
            const label = item.querySelector('label span').innerText.toLowerCase();
            if (label.includes(searchValue)) {
                item.style.display = ''; // Show item
            } else {
                item.style.display = 'none'; // Hide item
            }
        });
    }

    // Close dropdown if clicked outside
    window.addEventListener('click', function(event) {
        const dropdownMenu = document.getElementById('dropdownMenu');
        const dropdownButton = document.getElementById('dropdownButton');
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>

@endsection
