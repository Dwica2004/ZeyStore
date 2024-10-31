<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    // Add the fillable fields here
    protected $fillable = [
        'name',      // User's name
        'email',     // User's email
        'phone',     // User's phone number
        'password',  // User's hashed password
        'role'       // Role of the user (e.g., 'member' or 'admin')
    ];

    // Hide password and remember_token fields when serializing the model
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Tambahkan konstanta untuk role
    const ROLE_MEMBER = 'member';
    const ROLE_ADMIN = 'admin';

    // Helper method untuk cek role
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isMember()
    {
        return $this->role === self::ROLE_MEMBER;
    }

    // You can also define relationships here, such as orders if needed
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
