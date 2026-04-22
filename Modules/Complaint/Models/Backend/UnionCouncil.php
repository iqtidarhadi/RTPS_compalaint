<?php

namespace Modules\Complaint\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UnionCouncil extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'code']);
    }

    public function tehsil()
    {
        return $this->belongsTo(Tehsil::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
