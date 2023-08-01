<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tim extends Model
{
    use HasFactory;

    protected $fillable =[
        'logo',
        'nama',
        'ketua',
        'desk'
    ];

    public function ketua()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function anggota()
    {
        return $this->hasMany(User::class, 'tim_id');
    }
}
