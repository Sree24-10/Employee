<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tymon\JWTAuth\Contracts\JWTSubject; // ✅ Import JWTSubject

class User extends Authenticatable implements JWTSubject // ✅ Implement JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    // ✅ Implement JWT Methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // 🔹 Check if user is an Admin
    public function isSuperAdmin()
    {
        return $this->is_admin == 1;
    }

    // 🔹 Relationship with Employee Performance
    public function performance()
    {
        return $this->hasMany(EmployeePerformance::class, 'user_id');
    }

    // 🔹 Get Managers assigned to an Employee
    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'employee_manager', 'employee_id', 'manager_id');
    }

    // 🔹 Get Employees assigned to a Manager
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'employee_manager', 'manager_id', 'employee_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'employee_id');
    }
}
