<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'nama_penyewa',
        'nomor_kamar',
        'bulan',
        'nominal',
        'bukti',
        'status',
    ];
}