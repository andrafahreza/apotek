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
        'keranjang_id',
        'nomor_pembelian',
        'pembayaran',
        'keterangan',
        'status_ongkir',
        'status_pembayaran',
        'status_pembelian',
        'bukti_transfer',
        'bukti_transfer_kembali',
        'kurir',
        'alamat',
        'ongkir'
    ];

    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function keranjang(){
        return $this->belongsTo(Keranjang::class, "keranjang_id");
    }
}
