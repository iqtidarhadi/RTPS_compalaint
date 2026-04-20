<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class District extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    //logging Activity of Model 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }

    public function user()
    {
        return $this->hasMany(\App\Models\User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function tehsils()
    {
        return $this->hasMany(Tehsil::class);
    }
}
