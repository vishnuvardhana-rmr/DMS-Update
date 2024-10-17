<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Document extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'folder_id', 'path', 'created_by']; // Add other relevant fields here

    // Define the relationship with Folder
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'folder_user'); // Assuming folder_user is your pivot table
    }

    
}



