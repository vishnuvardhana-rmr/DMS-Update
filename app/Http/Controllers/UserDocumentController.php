<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
{
    // Display user's accessible folders
    public function index()
    {
        $user = Auth::user();
        $folders = Folder::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->whereNull('parent_id')->get(); // Fetch top-level folders accessible to the user

        return view('user.documents.index', compact('folders'));
    }

    // Show the folder contents, including subfolders and documents (same as before)
    public function show($folderId)
    {
        $folder = Folder::findOrFail($folderId);
        $subfolders = $folder->subfolders;
        $documents = Document::where('folder_id', $folderId)->get();

        return view('user.documents.show', compact('folder', 'subfolders', 'documents'));
    }

    
    public function open($id)
{
    // Find the document by ID
    $document = Document::findOrFail($id);

    // Retrieve the file path from the database
    $path = $document->path; // 'documents/filename.pdf'

    // Check if the path is null
    if (!$path) {
        return redirect()->back()->with('error', 'File path not found.');
    }

    // Check if the file exists in the public storage
    if (!Storage::disk('public')->exists($path)) {
        return redirect()->back()->with('error', 'File not found.');
    }

    // Get the full path to the file in the storage folder
    $file = Storage::disk('public')->path($path);

    // Return the file to the browser
    return response()->file($file);
}
    
    
}
