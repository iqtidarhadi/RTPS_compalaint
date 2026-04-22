<?php

namespace Modules\Complaint\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintDocument extends Model
{
    use HasFactory;

    protected $table = 'complaint_documents';
    
    protected $fillable = [
        'complaint_id',
        'uploaded_by',
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

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Accessor for full URL
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}