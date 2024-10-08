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
        'keranjang_id',
        'status',
        'alasan_penolakan'
    ];

    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function keranjang(){
        return $this->belongsTo(Keranjang::class, "keranjang_id");
    }
}
