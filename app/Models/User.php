<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
      // Relationships
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Check if user is verified
    public function isVerified()
    {
        return $this->is_verified == true;
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    // Get role badge
    public function getRoleBadgeAttribute()
    {
        $badges = [
            'admin' => 'bg-danger',
            'teacher' => 'bg-primary',
            'student' => 'bg-success',
            'parent' => 'bg-warning',
            'accountant' => 'bg-info',
        ];
        return $badges[$this->role] ?? 'bg-secondary';
    }

    // Get role name
    public function getRoleNameAttribute()
    {
        return ucfirst($this->role);
    }
}