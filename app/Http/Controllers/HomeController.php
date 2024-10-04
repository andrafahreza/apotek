<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pemasok;
use App\Models\Penjualan;
use App\Models\Persediaan;
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
        $persediaan = Persediaan::where('jumlah_obat', '>', 0)->get();
        $filter = "";

        return view('back.pages.home', compact('title', 'customer', 'obat', 'penjualan', 'pemasok', 'persediaan', 'filter'));
    }

    public function homeSearch(Request $request)
    {
        $title = "beranda";
        $customer = User::where('role', 'customer')->get();
        $obat = Obat::get();
        $penjualan = Penjualan::where('status_pembelian', 'sukses')->get();
        $pemasok = Pemasok::get();

        $obatFilter = Obat::where('nama_obat', 'like', "%$request->filter%")->get()->pluck("id");
        $persediaan = Persediaan::whereIn("obat_id", $obatFilter)->where('jumlah_obat', '>', 0)->get();
        $filter = $request->filter;

        return view('back.pages.home', compact('title', 'customer', 'obat', 'penjualan', 'pemasok', 'persediaan', 'filter'));
    }
}
