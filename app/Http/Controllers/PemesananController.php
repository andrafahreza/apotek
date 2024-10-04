<?php

namespace App\Http\Controllers;

use App\Models\KeranjangObat;
use App\Models\Pemesanan;
use App\Models\Persediaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function validasi_pemesanan($search = null)
    {
        $title = "validasi-pemesanan";
        $user = User::where("name", "LIKE", "%".$search."%")->get()->pluck('id');
        $data = Pemesanan::where(function ($query) use ($user) {
                if ($user != null) {
                    $query->whereIn('user_id', $user);
                }
            })
            ->latest()
            ->get();

        return view('back.pages.menu.validasi-pemesanan', compact('title', 'data'));
    }

    public function validasi_tolak(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Pemesanan::findOrFail($request->id);
            $data->status = "ditolak";
            $data->alasan_penolakan = $request->alasan_penolakan;

            if (!$data->update()) {
                throw new \Exception("Terjadi kesalahan, silahkan coba lagi");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menolak data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function validasi_kurang_obat(Request $request)
    {
        DB::beginTransaction();

        try {
            $keranjangObat = KeranjangObat::findOrFail($request->id);
            $keranjangObat->kuantiti = $keranjangObat->kuantiti - $request->kurang;
            $keranjangObat->total_harga = $keranjangObat->kuantiti * $keranjangObat->obat->harga;
            $keranjangObat->save();

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menerima data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function validasi_tambah_obat(Request $request)
    {
        DB::beginTransaction();

        try {
            $keranjangObat = KeranjangObat::findOrFail($request->id);
            $keranjangObat->kuantiti = $keranjangObat->kuantiti + $request->tambah;
            $keranjangObat->total_harga = $keranjangObat->kuantiti * $keranjangObat->obat->harga;
            $keranjangObat->save();

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menerima data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function validasi_terima(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Pemesanan::findOrFail($request->id);
            $data->status = "diterima";

            if (!$data->update()) {
                throw new \Exception("Terjadi kesalahan, silahkan coba lagi");
            }

            foreach ($data->keranjang->obat as $isi) {
                $persediaan = Persediaan::where('obat_id', $isi->obat_id)->where('jumlah_obat', '>', 0)->get();
                $sisa = $isi->kuantiti;
                foreach ($persediaan as $value) {
                    if ($value->jumlah_obat < $sisa) {
                        $stok = Persediaan::find($value->id);
                        $sisa -= $stok->jumlah_obat;

                        $stok->jumlah_obat = 0;
                        if (!$stok->update()) {
                            throw new \Exception("Gagal memperbarui stok obat, silahkan coba lagi");
                        }
                    } else {
                        $stok = Persediaan::find($value->id);
                        $stok->jumlah_obat = $stok->jumlah_obat - $sisa;
                        if (!$stok->update()) {
                            throw new \Exception("Gagal memperbarui stok obat, silahkan coba lagi");
                        }
                        break;
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menerima data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
