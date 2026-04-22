<?php

namespace Modules\Complaint\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;


class AppFlow extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    //logging Activity of Model 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }



    public function filterStatuses()
    {
        return $this->hasMany(FilterStatus::class);
    }

    public function filterStatus($type = 'read')
    {
        return $this->hasMany(FilterStatus::class)->where('type', $type);
    }


    public function isReadStatusAvailable($status_id)
    {
        $count = $this->filterStatus('read')->where('status_id', $status_id)->count() > 0;
        if ($count > 0) {
            return true;
        }
        return false;
    }

    public function isActionStatusAvailable($status_id)
    {
        $count = $this->filterStatus('action')->where('status_id', $status_id)->count() > 0;
        if ($count > 0) {
            return true;
        }
        return false;
    }
}
