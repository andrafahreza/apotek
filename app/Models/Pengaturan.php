<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table    = 'pengaturan';
    protected $fillable = [
        'id',
        'nama',
        'alamat',
        'telepon',
        'email',
        'map',
        'nama_kontak',
        'profile'
    ];
}
