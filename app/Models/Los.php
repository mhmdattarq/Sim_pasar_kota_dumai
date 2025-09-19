<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Los extends Model
{
    protected $table = 'los'; // nama tabel
    protected $primaryKey = 'id'; // primary key

    protected $fillable = [
        'nomor_los',
        'ukuran_los',
        'harga_sewa',
        'satuan_retribusi',
        'status_los',
        'lokasi_los',
        'pasar_id',
    ];
}