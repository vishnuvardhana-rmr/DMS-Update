@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-4xl font-bold mb-6 text-center text-blue-600">{{ $folder->name }}</h1>

    <!-- Display Subfolders -->
    <div class="mb-6">
        <h3 class="text-2xl font-semibold mb-4">Subfolders</h3>
        @if($subfolders->isEmpty())
            <p class="text-center text-gray-500">No folders available.</p>
        @else
            <div class="border border-blue-300 rounded-lg p-4 bg-white shadow-md">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6"> <!-- Adjusted to xl:grid-cols-5 -->
                    @foreach($subfolders as $subfolder)
                        <a href="{{ route('user.documents.show', $subfolder->id) }}" class="flex flex-col items-center justify-center p-3 rounded-lg border border-blue-200 bg-blue-50 transition-transform transform hover:scale-105 hover:shadow-lg cursor-pointer">
                            <i class="fa fa-folder fa-3x text-blue-600 mb-2" aria-hidden="true"></i> <!-- Folder icon -->
                            <h5 class="text-lg font-medium text-blue-600 text-center">{{ $subfolder->name }}</h5>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

<!-- Display Documents -->
<div>
    <h3 class="text-2xl font-semibold mb-4">Documents</h3>
    @if($documents->isEmpty())
        <p class="text-center text-gray-500">No documents available.</p>
    @else
        <div class="border border-blue-300 rounded-lg p-4 bg-white shadow-md">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach($documents as $document)
                    <a href="{{ route('document.open', $document->id) }}" target="_blank" class="flex flex-col items-center justify-center p-3 rounded-lg border border-blue-200 bg-blue-50 transition-transform transform hover:scale-105 hover:shadow-lg cursor-pointer">
                        <i class="fa fa-file fa-3x text-blue-600 mb-2" aria-hidden="true"></i> <!-- Increased size to fa-3x -->
                        <h5 class="text-sm font-medium text-blue-600 text-center">{{ $document->name }}</h5> <!-- Keeping font size smaller -->
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>



</div>
@endsection
