<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    use HasFactory;

    protected $table    = 'persediaan';
    protected $fillable = [
        'id',
        'pembelian_id',
        'obat_id',
        'jumlah_obat',
        'tgl_masuk',
        'tgl_kadaluarsa',
    ];

    public function obat(){
        return $this->belongsTo(Obat::class, "obat_id");
    }
}
