<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Complainant extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'complainants';
    
    protected $fillable = [
        'cnic_number',
        'name',
        'gender',
        'contact_number',
        'id_type',
        'email',
        'province',
        'district',
        'postal_address',
        'cnic_front_path',
        'cnic_back_path',
        'email_verified_at',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function appeals()
    {
        return $this->hasMany(Appeal::class);
    }

    public function documents()
    {
        return $this->morphMany(ComplaintDocument::class, 'documentable');
    }

    // Accessors
    public function getFullAddressAttribute()
    {
        return "{$this->postal_address}, {$this->district}, {$this->province}";
    }

    // Scopes
    public function scopeByCNIC($query, $cnic)
    {
        return $query->where('cnic_number', $cnic);
    }

    public function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}