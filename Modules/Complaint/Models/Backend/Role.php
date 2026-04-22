<?php

namespace Modules\Complaint\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as Model;


class Role extends Model
{
    use HasFactory;

    // setter for is_generic attribute to 1 or 0
    public function setIsGenericAttribute($value)
    {
        $this->attributes['is_generic'] = $value ? 1 : 0;
    }
}
