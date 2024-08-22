<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table    = 'pemesanan';
    protected $fillable = [
        'id',
        'user_id',
        'obat_id',
        'status',
        'jumlah',
        'harga',
        'alasan_penolakan'
    ];

    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function obat(){
        return $this->belongsTo(Obat::class, "obat_id");
    }
}
