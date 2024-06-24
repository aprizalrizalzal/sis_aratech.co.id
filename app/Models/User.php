<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Mendefinisikan relasi one-to-many dengan model Role
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // Metode untuk memeriksa apakah pengguna memiliki peran tertentu
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    // Mendefinisikan relasi one-to-one dengan model Customer
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    // Mendefinisikan relasi one-to-many dengan model ServiceDetail
    public function serviceDetails()
    {
        return $this->hasMany(ServiceDetail::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('created_at');
        });
    }
}
