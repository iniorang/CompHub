<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'name',
        'email',
        'password',
        'type',
        'alamat',
        'telp',
        'anggotaTim',
        'disabled',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function type(): Attribute
    {
        return new Attribute(
            get: fn($value) => ["user", "admin"][$value],
        );
    }

    public function kompetisis()
    {
        return $this->belongsToMany(kompetisi::class, 'user_ikut_komps', 'user_id', 'komps_id');
    }

    public function tim()
    {
        return $this->belongsToMany(Tim::class, 'user_tim', 'user_id', 'tim_id')->withTimestamps();
    }

    public function timKetua()
    {
        return $this->hasMany(Tim::class, 'ketua');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function requests()
    {
        return $this->belongsToMany(Tim::class, 'request_joins', 'user_id', 'tim_id')
            ->withPivot('status')
            ->withTimestamps();
    }
}