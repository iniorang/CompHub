<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tim extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'nama',
        'ketua',
        'desk'
    ];

    public function ketua()
    {
        return $this->belongsTo(User::class, 'ketua');
    }

    public function anggota()
    {
        return $this->belongsToMany(User::class, 'user_tim', 'tim_id', 'user_id')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tim', 'tim_id', 'user_id')->withTimestamps();
    }

    // Model Tim
    public function request()
    {
        return $this->hasMany(Request::class, 'tim_id');
    }
}
