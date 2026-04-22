<?php

namespace Modules\Complaint\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'province_id',
        'ur_title',
        'short_title',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the district that owns the division.
     */
    public function district()
    {
        return $this->hasMany(District::class);
    }

    /**
     * Get the tehsils for the division.
     */
    public function tehsils()
    {
        return $this->hasMany(Tehsil::class);
    }


    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
}
