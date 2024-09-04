<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\KeranjangObat;
use App\Models\Obat;
use App\Models\Pemesanan;
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

        return view('front.index', compact('obatDokter', 'obatBiasa'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $obatDokter = Obat::where('jenis_obat', 'obat dengan resep dokter')->where('nama_obat', 'like', "%$search%")->get();
        $obatBiasa = Obat::where('jenis_obat', 'obat tanpa resep dokter')->where('nama_obat', 'like', "%$search%")->get();

        return view('front.index', compact('obatDokter', 'obatBiasa'));
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
        $keranjang = Keranjang::where('status', 'open')->findOrFail($id);
        $rekening = Rekening::get();

        return view('front.beli', compact('keranjang', 'rekening'));
    }

    public function pesan($id = null)
    {
        $data = Keranjang::where('status', 'open')->findOrFail($id);

        return view('front.pesan', compact('data'));
    }

    public function pembayaran(Request $request)
    {
        DB::beginTransaction();

        try {
            $keranjang = Keranjang::findOrFail($request->keranjang_id);

            $data = [
                "user_id" => Auth::user()->id,
                "keranjang_id" => $request->keranjang_id,
                "nomor_pembelian" => "unknown",
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

            foreach ($keranjang->obat as $isi) {
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

            $keranjang->status = "close";
            $keranjang->update();

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
            $keranjang = Keranjang::findOrFail($request->id);
            $data = [
                "user_id" => Auth::user()->id,
                "keranjang_id" => $request->keranjang_id,
                "status" => "menunggu",
            ];

            $pemesanan = Pemesanan::create($data);

            if (!$pemesanan->save()) {
                throw new \Exception("Terjadi kesalahan, silahkan coba lagi");
            }

            foreach ($pemesanan->keranjang->obat as $isi) {
                $persediaan = Persediaan::where('obat_id', $isi->obat_id)->where('jumlah_obat', '>', 0)->get();
                $sisa = $isi->kuantitas;
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

            $keranjang->status = "close";
            $keranjang->update();

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

    public function lihat_obat($id = null)
    {
        $obat = Obat::findOrFail($id);
        $stok = Persediaan::where('obat_id', $obat->id)->sum('jumlah_obat');

        return view('front.lihat-obat', compact('obat', 'stok'));
    }

    public function tambah_keranjang(Request $request)
    {
        try {
            $obat = Obat::findOrFail($request->obat_id);
            $stok = Persediaan::where('obat_id', $request->obat_id)->sum('jumlah_obat');

            if ($stok < $request->total) {
                throw new \Exception("Stok obat tidak mencukupi");
            }

            $keranjangId = null;
            $obatId = null;

            $semuaKeranjang = Keranjang::with(['obat'])
            ->where('user_id', Auth::user()->id)
            ->where('status', 'open')
            ->first();
            if (!empty($semuaKeranjang)) {
                $keranjangId = $semuaKeranjang->id;
                foreach ($semuaKeranjang->obat as $value) {
                    if ($value->obat_id == $request->obat_id) {
                        $obatId = $value->obat_id;
                    }
                }
            }

            if ($keranjangId != null) {
                if ($obatId != null) {
                    $keranjangObat = KeranjangObat::where('keranjang_id', $keranjangId)
                    ->where('obat_id', $obatId)
                    ->first();

                    $keranjangObat->kuantiti = $keranjangObat->kuantiti + $request->total;
                    $keranjangObat->total_harga = $keranjangObat->kuantiti * $obat->harga;

                    if ($stok < $keranjangObat->kuantiti) {
                        throw new \Exception("Jumlah obat tidak mencukupi dengan yang ada di keranjang kamu");
                    }

                    $keranjangObat->update();
                } else {
                    $keranjangObat = KeranjangObat::create([
                        "keranjang_id" => $keranjangId,
                        "obat_id" => $obat->id,
                        "kuantiti" => $request->total,
                        "total_harga" => $request->total * $obat->harga
                    ]);
                }
            } else {
                $keranjang = Keranjang::create([
                    "user_id" => Auth::user()->id,
                    "status" => "open"
                ]);

                $keranjangObat = KeranjangObat::create([
                    "keranjang_id" => $keranjang->id,
                    "obat_id" => $request->obat_id,
                    "kuantiti" => $request->total,
                    "total_harga" => $request->total * $obat->harga
                ]);
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function lihat_keranjang()
    {
        $data = Keranjang::where('user_id', Auth::user()->id)->where('status', 'open')->first();

        return view('front.lihat-keranjang', compact('data'));
    }

    public function konfirmasi_pembelian(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Penjualan::findOrFail($request->id);
            $data->status_pembelian = "sukses";

            if (!$data->update()) {
                throw new \Exception("Terjadi kesalahan, silahkan coba lagi");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil memperbarui data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function hapus_isi_keranjang(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = KeranjangObat::findOrFail($request->id);
            $keranjangId = $data->keranjang_id;

            if (!$data->delete()) {
                throw new \Exception("Terjadi kesalahan, silahkan coba lagi");
            }

            $keranjang = Keranjang::find($keranjangId);
            if ($keranjang->obat->count() == 0) {
                $keranjang->status = "close";
                $keranjang->update();
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil memperbarui keranjang");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
