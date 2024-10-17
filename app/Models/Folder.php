<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id','created_by','user_id'];

    // Relationship to get subfolders
    public function subfolders()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }

    // Relationship to get documents
    public function documents()
    {
        return $this->hasMany(Document::class); // Assuming you have a Document model
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'folder_user'); // Assuming folder_user is your pivot table
    }

    public function folders()
    {
        return $this->belongsToMany(Folder::class)->withPivot('access_level');
    }
}
