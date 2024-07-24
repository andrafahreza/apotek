<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table    = 'pembelian';
    protected $fillable = [
        'id',
        'no_pembelian',
        'pemasok_id',
        'obat_id',
        'jumlah_obat',
        'total_bayar',
    ];

    public function pemasok(){
        return $this->belongsTo(Pemasok::class, "pemasok_id");
    }

    public function obat(){
        return $this->belongsTo(Obat::class, "obat_id");
    }

    public function persediaan(){
        return $this->hasOne(Persediaan::class, "pembelian_id", "id");
    }
}
