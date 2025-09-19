<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelataran extends Model
{
    protected $table = 'pelatarans';

    // Mass assignable fields
    protected $fillable = [
        'nomor_pelataran',
        'ukuran_pelataran',
        'harga_sewa',
        'satuan_retribusi',
        'kategori_pelataran',
        'lokasi_pelataran',
        'pasar_id',
    ];
}