<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pemasok;
use App\Models\Pembelian;
use App\Models\Persediaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index($search = null)
    {
        $title = "pembelian";
        $data = Pembelian::with(['obat', 'pemasok'])
        ->where(function ($query) use ($search) {
            if ($search != null) {
                $query->where('no_pembelian', 'like', "%$search%");
            }
        })
        ->latest()
        ->get();

        $pemasok = Pemasok::get();
        $obat = Obat::get();

        return view('back.pages.menu.pembelian', compact('title', 'data', 'pemasok', 'obat'));
    }

    public function simpan(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $data = [
                "no_pembelian" => $request->no_pembelian,
                "pemasok_id" => $request->pemasok_id,
                "obat_id" => $request->obat_id,
                "jumlah_obat" => $request->jumlah_obat,
                "total_bayar" => $request->total_bayar
            ];

            $check = Pembelian::where('no_pembelian', $request->no_pembelian)->first();
            if (!empty($check)) {
                throw new \Exception("Pemasok $request->no_pembelian sudah terdaftar");
            }

            $pembelian = Pembelian::create($data);
            if (!$pembelian->save()) {
                throw new \Exception("Gagal menambahkan data");
            }

            $persediaan = Persediaan::create([
                'obat_id' => $request->obat_id,
                'pembelian_id' => $pembelian->id,
                'jumlah_obat' => $request->jumlah_obat,
                'tgl_masuk' => date('Y-m-d'),
                'tgl_kadaluarsa' => $request->tgl_kadaluarsa,
            ]);

            if (!$persediaan->save()) {
                throw new \Exception("Terjadi kesalahan saat menambah persediaan obat, silahkan coba lagi");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menyimpan data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function show($id = null)
    {
        $data = Pembelian::findOrFail($id);
        $data->tgl_kadaluarsa = $data->persediaan->tgl_kadaluarsa;

        try {
            return response()->json([
                'alert' => 1,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            return response()->json([
                'alert' => 0,
                'message' => "Terjadi kesalahan: $message"
            ]);
        }
    }
}
