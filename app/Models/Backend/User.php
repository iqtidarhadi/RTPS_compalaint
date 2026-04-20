<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'code_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'age' => 'integer',
        ];
    }

    /**
     * Get user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Scope for active users only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by user type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('user_type', $type);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    /**
     * Check if user is government official.
     */
    public function isGovernmentOfficial(): bool
    {
        return in_array($this->user_type, [
            'department_user', 
           
        ]);
    }

    public function department()
{
    return $this->belongsTo(Department::class);
}
}