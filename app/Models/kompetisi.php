<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kompetisi extends Model
{
    use HasFactory;

    protected $fillable =[
        'img',
        'nama',
        'desk',
        'org',
    ];

    public function peserta(){
        return $this->belongsToMany(User::class,'user_ikut_komps','komps_id','user_id');
    }
}
