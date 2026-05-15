<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'phone', 'address', 'document', 'avatar', 'active', 'google_id',
        'email_verified_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed', 'active' => 'boolean'];

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isBusiness(): bool { return $this->role === 'business'; }
    public function isUser(): bool { return $this->role === 'user'; }
}
