<?php

namespace Modules\Complaint\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function getBadgeAttribute()
    {
        return '<span class="badge ' . $this->badgeClass . '">' . $this->text . '</span>';
    }

    public function getRawAttribute()
    {
        return '<span class="badge ' . $this->badgeClass . '">' . $this->text . '</span>';
    }


    public function mbMasters()
    {
        return $this->hasMany(MbMaster::class);
    }


}
