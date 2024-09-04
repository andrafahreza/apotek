<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pemasok;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $title = "beranda";
        $customer = User::where('role', 'customer')->get();
        $obat = Obat::get();
        $penjualan = Penjualan::where('status_pembelian', 'sukses')->get();
        $pemasok = Pemasok::get();

        return view('back.pages.home', compact('title', 'customer', 'obat', 'penjualan', 'pemasok'));
    }
}
