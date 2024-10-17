@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-4xl font-bold mb-6 text-indigo-700">Grant Access to {{ $folder->name }}</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.documents.store-access') }}" method="POST">
        @csrf
        <input type="hidden" name="folder_id" value="{{ $folder->id }}">

        <div class="mb-4">
            <label for="folder_name" class="block text-sm font-medium text-gray-700">Folder Name</label>
            <input type="text" id="folder_name" value="{{ $folder->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" disabled>
        </div>

        <div class="mb-4">
            <label for="user_ids" class="block text-sm font-medium text-gray-700">Select Users</label>
            <select id="user_ids" name="user_ids[]" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="access_level" class="block text-sm font-medium text-gray-700">Access Level</label>
            <select id="access_level" name="access_level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="read">Read</option>
                <option value="write">Write</option>
                <option value="edit">edit</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="comment" class="block text-sm font-medium text-gray-700">Comment (optional)</label>
            <textarea id="comment" name="comment" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
        </div>

        <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-500">
            Grant Access
        </button>
    </form>
</div>
@endsection
