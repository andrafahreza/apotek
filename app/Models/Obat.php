<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table    = 'obat';
    protected $fillable = [
        'id',
        'nama_obat',
        'jenis_obat',
        'harga',
        'photo',
        'keterangan'
    ];

    public function stok(){
        return $this->hasMany(Persediaan::class, "obat_id", "id");
    }
}
