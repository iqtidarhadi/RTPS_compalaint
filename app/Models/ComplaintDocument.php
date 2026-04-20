<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintDocument extends Model
{
    use HasFactory;

    protected $table = 'complaint_documents';
    
    protected $fillable = [
        'documentable_type',
        'documentable_id',
        'document_type',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
    ];

    // Polymorphic relationship
    public function documentable()
    {
        return $this->morphTo();
    }

    // Accessor for full URL
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}