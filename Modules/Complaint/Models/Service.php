<?php

namespace Modules\Complaint\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'dept_id',
        'department_id',
        'service_name',
        'sla_days',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

     public function getStatusBadgeAttribute()
    {
        return $this->is_active 
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Inactive</span>';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where(function ($innerQuery) use ($departmentId) {
            $innerQuery->where('dept_id', $departmentId);

            if (in_array('department_id', $this->getFillable(), true)) {
                $innerQuery->orWhere('department_id', $departmentId);
            }
        });
    }
}
