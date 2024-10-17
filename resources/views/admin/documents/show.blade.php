@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold mb-6 text-center text-blue-600">{{ $folder->name }}</h1> <!-- Blue touch added here -->

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-2xl font-semibold mb-4">Manage SubFolders and Documents</h2>

        <div class="mb-4">
            <label for="add_type" class="block text-sm font-medium text-gray-700">Select Type</label>
            <select id="add_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="toggleFields()">
                <option value="">Choose an option</option>
                <option value="folder">Folder</option>
                <option value="document">Document</option>
            </select>
        </div>

        <form id="add_form" action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 hidden">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $folder->id }}">
            <input type="hidden" name="add_type" id="add_type_hidden">
            <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">

            <div id="folder_fields" class="hidden">
                <label for="folder_name" class="block text-sm font-medium text-gray-700">New Folder Name</label>
                <input type="text" name="folder_name" id="folder_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Enter folder name" />
            </div>

            <div id="document_fields" class="hidden">
                <label for="subfolder_id" class="block text-sm font-medium text-gray-700">Select Subfolder (optional)</label>
                <select name="subfolder_id" id="subfolder_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">None (Optional)</option>
                    @foreach($subfolders as $subfolder)
                        <option value="{{ $subfolder->id }}">{{ $subfolder->name }}</option>
                    @endforeach
                </select>

                <label for="document" class="block text-sm font-medium text-gray-700 mt-4">Upload Document (optional)</label>
                <input type="file" name="document" id="document" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-500">
                Add Folder or Document
            </button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Subfolders</h2>
        <div class="grid grid-cols-4 gap-4"> <!-- Changed to 4 columns -->
            @foreach($subfolders as $subfolder)
                <a href="{{ route('admin.documents.show', $subfolder->id) }}" class="flex flex-col items-center justify-center bg-blue-50 p-4 rounded-lg border border-blue-200 hover:bg-blue-100 transition ease-in-out duration-200 shadow-md">
                    <i class="fas fa-folder text-3xl text-blue-600 mb-2"></i>
                    <span class="text-sm font-medium text-blue-600">{{ $subfolder->name }}</span>
                </a>
            @endforeach
        </div>

        <h2 class="text-xl font-semibold mb-4 mt-6">Documents</h2>
        <div class="grid grid-cols-4 gap-4"> <!-- Changed to 4 columns -->
            @foreach ($documents as $document)
                <div class="flex flex-col items-center justify-center bg-blue-50 p-4 rounded-lg border border-blue-200 hover:bg-blue-100 transition ease-in-out duration-200 shadow-md">
                    <i class="fas fa-file-alt text-3xl text-blue-600 mb-2"></i>
                    <span class="text-sm font-medium text-center overflow-hidden whitespace-nowrap text-ellipsis w-full" title="{{ $document->name }}">{{ $document->name }}</span>
                    <a href="{{ route('document.open', $document->id) }}" target="_blank" class="text-blue-600 mt-2 hover:underline" target="_blank">Open Document</a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function toggleFields() {
    const addType = document.getElementById('add_type').value;
    const folderFields = document.getElementById('folder_fields');
    const documentFields = document.getElementById('document_fields');
    const form = document.getElementById('add_form');
    const addTypeHidden = document.getElementById('add_type_hidden');

    folderFields.style.display = addType === 'folder' ? 'block' : 'none';
    documentFields.style.display = addType === 'document' ? 'block' : 'none';
    form.classList.toggle('hidden', !addType);
    addTypeHidden.value = addType;
}

// Hide the success message after 3 seconds
window.onload = function() {
    const successMessage = document.getElementById('success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.opacity = '0';
            setTimeout(() => successMessage.remove(), 300); // Remove after fade out
        }, 3000);
    }
};
</script>
@endsection
