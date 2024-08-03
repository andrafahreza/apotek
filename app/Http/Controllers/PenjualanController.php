<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Persediaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $title = "penjualan";
        $obat = Obat::get();

        return view('back.pages.menu.penjualan', compact('title', 'obat'));
    }

    public function jual(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'total_bayar' => 'required',
            ]);

            if ($request->stok < $request->jumlah_obat) {
                throw new \Exception("Stok obat tidak mencukupi");
            }

            $data = [
                "user_id" => Auth::user()->id,
                "obat_id" => $request->obat_id,
                "nomor_pembelian" => $request->nomor_pembelian,
                "jumlah_obat" => $request->jumlah_obat,
                "total_bayar" => $request->total_bayar,
                "pembayaran" => $request->pembayaran,
                "status_pembayaran" => "diterima",
                "status_pembelian" => "sukses"
            ];

            if ($request->pembayaran == "transfer") {
                $request->validate([
                    'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg',
                ]);

                $imageName = time().'.'.$request->bukti_transfer->extension();
                $request->bukti_transfer->move(public_path('/bukti_transfer/'), $imageName);
                $data['bukti_transfer'] = "/bukti_transfer/$imageName";
            }

            $penjualan = Penjualan::create($data);

            if (!$penjualan->save()) {
                throw new \Exception("Terjadi kesalahan, silahkan coba lagi");
            }

            $persediaan = Persediaan::where('obat_id', $request->obat_id)->where('jumlah_obat', '>', 0)->get();

            $sisa = $request->jumlah_obat;
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

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    // Transaksi
    public function transaksi_pembelian($search = null)
    {
        $title = "transaksi-pembelian";
        $pembelian = Pembelian::where(function($query) use($search) {
            if ($search != null) {
                $query->where('no_pembelian', $search);
            }
        })
        ->latest()->get();

        return view('back.pages.menu.transaksi.pembelian', compact('title', 'pembelian'));
    }

    public function transaksi_penjualan($search = null)
    {
        $title = "transaksi-penjualan";
        $penjualan = Penjualan::where(function($query) use($search) {
            if ($search != null) {
                $query->where('nomor_pembelian', $search);
            }
        })
        ->where('status_pembelian', 'sukses')->latest()->get();

        return view('back.pages.menu.transaksi.penjualan', compact('title', 'penjualan'));
    }

    // Validasi
    public function validasi_penjualan()
    {
        $title = "validasi";
        $data = Penjualan::where('nomor_pembelian', 'unknown')->latest()->get();

        return view('back.pages.menu.validasi-penjualan', compact('title', 'data'));
    }

    public function validasi_tolak(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Penjualan::findOrFail($request->id);
            $data->status_pembayaran = "ditolak";
            $data->status_pembelian = "gagal";
            $data->keterangan = $request->keterangan;

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

    public function validasi_terima(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Penjualan::findOrFail($request->id);
            $data->status_pembayaran = "diterima";
            $data->status_pembelian = "sukses";
            $data->nomor_pembelian = $request->nomor_pembelian;

            if (!$data->update()) {
                throw new \Exception("Terjadi kesalahan, silahkan coba lagi");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menerima data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
