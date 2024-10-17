@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold mb-6 text-center text-indigo-700">Manage Documents</h1>

    <div class="mb-6 text-right">
        <a href="{{ route('admin.documents.create') }}" class="bg-indigo-600 text-white py-2 px-4 rounded shadow hover:bg-indigo-500 transition duration-200">Add Folder</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($folders as $folder)
            <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition duration-300 transform hover:scale-105">
                <a href="{{ route('admin.documents.show', $folder->id) }}" class="flex flex-col items-center text-center">
                    <i class="fas fa-folder text-4xl text-indigo-600 mb-4"></i> <!-- Folder icon -->
                    <span class="text-lg font-semibold text-gray-800 hover:text-indigo-600 transition duration-200">{{ $folder->name }}</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
    