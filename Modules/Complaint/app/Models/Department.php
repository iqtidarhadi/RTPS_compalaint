<?php

namespace Modules\Complaint\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'dept_id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
}
