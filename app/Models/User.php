<?php

namespace App\Models;


use App\Enums\PermissionType;
use App\Models\Backend\AppFlow;
use App\Models\Backend\District;
use App\Models\Backend\Tehsil;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasFactory, HasApiTokens, Notifiable, HasRoles, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'text']);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'father_name',
        'cnic_no',
        'contact_no',
        'gender',
        'age',
        'address',
        'email',
        'password',
        'user_type',
        'verification_code',
        'code_expires_at',
        'is_active',
        'profile_photo',
        'last_login_at',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
         'code_expires_at' => 'datetime',
    ];



    // append is_main to user from branch
    protected $appends = ['role'];


    

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \Illuminate\Auth\Notifications\ResetPassword($token));
    }



    public function getRoleAttribute()
    {
        return $this->roles->pluck('name')->implode(', ') ?: 'No Role Assigned';
    }

   
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id')->withDefault(['name' => '']);
    }

    public function tehsil()
    {
        return $this->belongsTo(Tehsil::class)->withDefault(['name' => '']);
    }


    public function getReadStatus()
    {

        $appFlow = AppFlow::whereIn('role_id', $this->roles->pluck('id'))->first();
        if ($appFlow) {
            $filteredStatuses = $appFlow->filterStatus('read')->pluck('status_id')->toArray();
        } else {
            $filteredStatuses = [];
        }

        return $filteredStatuses;
    }

    public function getActionStatuts()
    {
        $appFlow = AppFlow::whereIn('role_id', $this->roles->pluck('id'))->first();
        if ($appFlow) {
            $filteredStatuses = $appFlow->filterStatus('action')->pluck('status_id')->toArray();
        } else {
            $filteredStatuses = [];
        }
        return $filteredStatuses;
    }


    public function filters()
    {
        return AppFlow::whereIn('role_id', $this->roles->pluck('id'))->where('type', 'read')->first();
    }



    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class);
    }


    public function syncPermissions(array $permissions)
    {
        // Flatten the permissions into a single array for bulk operations
        $permissionData = [];
        foreach ($permissions as $type => $permissionIds) {
            if (!PermissionType::tryFrom($type)) {
                throw new \InvalidArgumentException("Invalid permission type: {$type}");
            }

            foreach ($permissionIds as $permissionId) {
                $permissionData[] = [
                    'user_id' => $this->id,
                    'type' => PermissionType::from($type)->value,
                    'permission_id' => $permissionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Delete existing permissions for the user
        $this->userPermissions()->delete();

        // Insert new permissions
        UserPermission::insert($permissionData);
    }
}
