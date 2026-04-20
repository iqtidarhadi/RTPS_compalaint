<?php

namespace App\Models;

use App\Models\Backend\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Officer extends Model
{
   

    protected $fillable = [
        'dept_id',
        'name',
        'designation',
        'email',
        'phone',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
}