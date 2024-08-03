<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table    = 'penjualan';
    protected $fillable = [
        'id',
        'user_id',
        'obat_id',
        'nomor_pembelian',
        'jumlah_obat',
        'total_bayar',
        'pembayaran',
        'keterangan',
        'status_pembayaran',
        'status_pembelian',
        'bukti_transfer',
        'kurir'
    ];

    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function obat(){
        return $this->belongsTo(Obat::class, "obat_id");
    }
}
