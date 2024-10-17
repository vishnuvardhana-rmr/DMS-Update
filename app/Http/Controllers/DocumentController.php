<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class DocumentController extends Controller
{
    public function index()
    {
        $folders = Folder::whereNull('parent_id')->get(); // Fetch top-level folders
        return view('admin.documents.index', compact('folders'));
    }

    public function create()
    {
        $folders = Folder::all(); // Fetch all folders for dropdowns
        return view('admin.documents.create', compact('folders'));
    }

    public function show($id)
    {
        $folder = Folder::findOrFail($id);
        $subfolders = Folder::where('parent_id', $id)->get();
        $documents = Document::where('folder_id', $id)->get();

        return view('admin.documents.show', compact('folder', 'subfolders', 'documents'));
    }

    public function boot()
    {
        View::composer('layouts.navigation', function ($view) {
            $folder = session('current_folder'); // Assuming you store the current folder ID in session
            $view->with('folder', Folder::find($folder));
        });
    }

    public function store(Request $request)
    {
        $request->validate([
            'folder_name' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:folders,id',
            'subfolder_id' => 'nullable|exists:folders,id',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        
        if ($request->filled('folder_name')) {
            $user = Auth::user();
            $folderName = $request->input('folder_name'); // Get the folder name
            $folder = Folder::create([
                'name' => $folderName,
                'parent_id' => $request->input('parent_id'),
                'created_by' => $user ? $user->id : null,
            ]);
        
            // Check if the folder has a parent_id to determine redirection
            if ($request->filled('parent_id')) {
                // It's a subfolder
                return redirect()->route('admin.documents.show', $request->input('parent_id'))
                                 ->with('success', " {$folderName} created successfully!");
            } else {
                // It's a main folder
                return redirect()->route('admin.documents.index') // Adjust this to your actual index route
                                 ->with('success', " {$folderName} created successfully!");
            }
        }
        

        if ($request->hasFile('document')) {
            $folderId = $request->input('subfolder_id') ?? $request->input('parent_id');
            $path = $request->file('document')->store('documents', 'public');

            $documentName = $request->file('document')->getClientOriginalName();

            Document::create([
                'folder_id' => $folderId,
                'name' => $documentName,
                'path' => $path,
            ]);

            return redirect()->route('admin.documents.show', $folderId)
                             ->with('success', 'Document uploaded successfully!');
        }

        return redirect()->back()->withErrors('Please provide a folder name or document.');
    }

    public function grantAccess($folderId)
    {
        $folder = Folder::findOrFail($folderId);
        $users = User::all();

        return view('admin.documents.grant_access', compact('folder', 'users'));
    }

    public function storeAccess(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'folder_id' => 'required|exists:folders,id',
            'access_level' => 'required|string',
            'comment' => 'nullable|string|max:255',
        ]);

        foreach ($request->user_ids as $userId) {
            DB::table('folder_user')->updateOrInsert(
                ['folder_id' => $request->folder_id, 'user_id' => $userId],
                [
                    'access_level' => $request->access_level,
                    'comment' => $request->comment,
                ]
            );
        }

        return redirect()->route('admin.documents.show', $request->folder_id)
                         ->with('success', 'Access granted successfully to selected users.');
    }



    public function open($id)
    {
        // Find the document by ID
        $document = Document::findOrFail($id);

        // Retrieve the file path from the database
        $path = $document->path;

        // Check if the path is valid
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
