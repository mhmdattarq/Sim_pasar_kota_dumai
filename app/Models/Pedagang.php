<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedagang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'alamat',
        'no_hp',
        'jenis_dagangan',
        'foto_ktp',
        'foto_diri',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}