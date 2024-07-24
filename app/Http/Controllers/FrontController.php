<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $obatDokter = Obat::where('jenis_obat', 'obat dengan resep dokter')->get();
        $obatBiasa = Obat::where('jenis_obat', 'obat tanpa resep dokter')->get();
        $pengaturan = Pengaturan::first();

        return view('front.index', compact('obatDokter', 'obatBiasa', 'pengaturan'));
    }

    public function login()
    {
        return view('back.login');
    }
}
