<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pemesanan;
use App\Models\Pengaturan;
use App\Models\Penjualan;
use App\Models\Persediaan;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $obatDokter = Obat::where('jenis_obat', 'obat dengan resep dokter')->get();
        $obatBiasa = Obat::where('jenis_obat', 'obat tanpa resep dokter')->get();
        $pengaturan = Pengaturan::first();

        return view('front.index', compact('obatDokter', 'obatBiasa', 'pengaturan'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $obatDokter = Obat::where('jenis_obat', 'obat dengan resep dokter')->where('nama_obat', 'like', "%$search%")->get();
        $obatBiasa = Obat::where('jenis_obat', 'obat tanpa resep dokter')->where('nama_obat', 'like', "%$search%")->get();
        $pengaturan = Pengaturan::first();

        return view('front.index', compact('obatDokter', 'obatBiasa', 'pengaturan'));
    }

    public function login()
    {
        return view('back.login');
    }

    public function register()
    {
        return view('back.register');
    }

    public function beli($id = null)
    {
        $obat = Obat::findOrFail($id);
        $stok = Persediaan::where('obat_id', $obat->id)->sum('jumlah_obat');
        $rekening = Rekening::get();

        return view('front.beli', compact('obat', 'stok', 'rekening'));
    }

    public function pesan($id = null)
    {
        $obat = Obat::findOrFail($id);
        $stok = Persediaan::where('obat_id', $obat->id)->sum('jumlah_obat');

        return view('front.pesan', compact('obat', 'stok'));
    }

    public function pembayaran(Request $request)
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
                "nomor_pembelian" => "unknown",
                "jumlah_obat" => $request->jumlah_obat,
                "total_bayar" => $request->total_bayar,
                "pembayaran" => "transfer",
                "status_pembayaran" => "menunggu",
                "status_pembelian" => "menunggu",
                'kurir' => $request->kurir
            ];

            $request->validate([
                'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg',
            ]);

            $imageName = time().'.'.$request->bukti_transfer->extension();
            $request->bukti_transfer->move(public_path('/bukti_transfer/'), $imageName);
            $data['bukti_transfer'] = "/bukti_transfer/$imageName";

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

            return redirect()->route('riwayat-pembelian-customer')->with("success", "Berhasil menyimpan data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function pemesanan()
    {
        $data = Pemesanan::where('user_id', Auth::user()->id)->latest()->get();

        return view('front.pemesanan', compact('data'));
    }

    public function pemesanan_customer(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'harga' => 'required',
            ]);

            if ($request->stok < $request->jumlah_obat) {
                throw new \Exception("Stok obat tidak mencukupi");
            }

            $data = [
                "user_id" => Auth::user()->id,
                "obat_id" => $request->obat_id,
                "jumlah" => $request->jumlah,
                "harga" => $request->harga,
                "status" => "menunggu",
            ];

            $pemesanan = Pemesanan::create($data);

            if (!$pemesanan->save()) {
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

            return redirect()->route('pemesanan-customer')->with("success", "Berhasil menyimpan data");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function riwayat()
    {
        $data = Penjualan::where('user_id', Auth::user()->id)->latest()->get();

        return view('front.riwayat', compact('data'));
    }

    public function profile()
    {
        return view('front.profile');
    }
}
