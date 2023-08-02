<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = ['kompetisi_id', 'total', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kompetisi()
    {
        return $this->belongsTo(Kompetisi::class);
    }
}
