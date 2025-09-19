<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasar extends Model
{
    protected $table = 'pasar';

    // Mass assignable fields
    protected $fillable = [
        'nama_pasar',
        'alamat',
        'foto_depan',
        'foto_belakang',
        'foto_dalam',
        'lokasi_peta',
    ];
}