<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'complainant_id',
        'appeal_number',
        'first_appeal_date',
        'appeal_description',
        'status',
        'review_remarks',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'first_appeal_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($appeal) {
            if (empty($appeal->appeal_number)) {
                $appeal->appeal_number = static::generateAppealNumber();
            }
        });
    }

    public static function generateAppealNumber()
    {
        return 'APL-' . date('Ymd') . '-' . Str::random(6);
    }

    // Relationships
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function complainant()
    {
        return $this->belongsTo(Complainant::class);
    }

    public function documents()
    {
        return $this->morphMany(ComplaintDocument::class, 'documentable');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}