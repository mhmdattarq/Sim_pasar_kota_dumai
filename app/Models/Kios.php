<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    protected $table = 'kios'; // nama tabel
    protected $primaryKey = 'id'; // primary key

    protected $fillable = [
        'nomor_kios',
        'ukuran_kios',
        'harga_sewa',
        'status_kios',
        'lokasi_kios',
        'pasar_id',
    ];
}
