<?php

namespace Modules\Complaint\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Menu extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $guarded = ['id'];

    //logging Activity of Model 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }

    public function permissionsList()
    {
        return $this->hasMany('Spatie\Permission\Models\Permission');
    }
}
