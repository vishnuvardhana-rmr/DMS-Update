@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">Your Folders</h1> <!-- Adjusted heading color to lighter blue -->

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Display Folders -->
    <div class="mb-6">
        @if($folders->isEmpty())
            <p class="text-center text-gray-500">No folders available.</p>
        @else
            <div class="border border-blue-300 rounded-lg p-4 bg-white shadow-md">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6"> <!-- Adjusted to xl:grid-cols-5 -->
                    @foreach($folders as $folder)
                        <div class="flex flex-col items-center justify-center p-3 rounded-lg border border-blue-200 bg-blue-50 transition-transform transform hover:scale-105 hover:shadow-lg cursor-pointer" onclick="location.href='{{ route('user.documents.show', $folder->id) }}'">
                            <i class="fas fa-folder fa-3x text-blue-600 mb-2"></i> <!-- Folder icon -->
                            <h5 class="text-lg font-medium text-blue-600 text-center">{{ $folder->name }}</h5>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Font Awesome -->
@endsection

<style>
    .title {
        font-size: 2rem; /* Decreased font size */
        font-weight: bold; /* Bold text */
        color: #007bff; /* Change color */
        text-shadow: 1px 1px 2px rgba(0, 123, 255, 0.5); /* Add shadow for depth */
        margin-bottom: 15px; /* Adjusted spacing below the title */
    }

    .folder-box {
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: box-shadow 0.3s;
        background-color: #f8f9fa; /* Light background color */
        padding: 20px; /* Padding for spacing inside the card */
        height: 120px; /* Reduced height for smaller folder boxes */
    }

    .folder-box:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        background-color: #e7f1ff; /* Light blue background on hover */
    }

    .card-title {
        overflow: hidden; /* Ensure text doesn't overflow */
        text-overflow: ellipsis; /* Add ellipsis for long text */
        white-space: nowrap; /* Prevent text from wrapping */
    }
</style>

@endsection
