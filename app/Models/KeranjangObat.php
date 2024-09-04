<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeranjangObat extends Model
{
    use HasFactory;

    protected $table    = 'keranjang_obat';
    protected $fillable = [
        'id',
        'keranjang_id',
        'obat_id',
        'kuantiti',
        'total_harga',
    ];

    public function keranjang(){
        return $this->belongsTo(Keranjang::class, "keranjang_id");
    }

    public function obat(){
        return $this->belongsTo(Obat::class, "obat_id");
    }
}
