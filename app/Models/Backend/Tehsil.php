<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Tehsil extends Model
{
    use HasFactory, SoftDeletes,LogsActivity;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }

    public function user(){
        return $this->hasMany(\App\Models\User::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function unionCouncils()
    {
        return $this->hasMany(UnionCouncil::class);
    }
}
