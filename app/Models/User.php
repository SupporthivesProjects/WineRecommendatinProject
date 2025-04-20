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
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'role',
        'status',
        'store_id',
    ];

    const ROLE_ADMIN = 'admin';
    const ROLE_STORE_MANAGER = 'store_manager';
    const ROLE_CUSTOMER = 'customer';

    public static function isValidRole($role)
    {
        return in_array($role, [self::ROLE_ADMIN, self::ROLE_STORE_MANAGER, self::ROLE_CUSTOMER]);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the store that the user belongs to.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a store manager.
     *
     * @return bool
     */
    public function isStoreManager()
    {
        return $this->role === 'store_manager';
    }
}
