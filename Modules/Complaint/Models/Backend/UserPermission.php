<?php

namespace Modules\Complaint\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Complaint\Enums\PermissionType;
use Modules\Complaint\Models\User;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'permission_id'];

    protected $casts = [
        'type' => PermissionType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
