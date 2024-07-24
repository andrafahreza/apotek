<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function index($search = null)
    {
        $title = "obat";
        $data = Obat::where(function ($query) use ($search) {
            if ($search != null) {
                $query->where('nama_obat', 'like', "%$search%");
            }
        })
        ->latest()
        ->get();

        return view('back.pages.datamaster.obat', compact('title', 'data'));
    }

    public function simpan(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $data = [
                "nama_obat" => $request->nama_obat,
                "jenis_obat" => $request->jenis_obat,
                "harga" => $request->harga
            ];

            if ($id != null) {
                $obat = Obat::findOrFail($id);

                $check = Obat::where('nama_obat', $request->nama_obat)
                ->where('id', '!=', $id)
                ->first();

                if (!empty($check)) {
                    throw new \Exception("Obat $request->nama_obat sudah terdaftar");
                }

                if (!$obat->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data");
                }
            } else {
                $check = Obat::where('nama_obat', $request->nama_obat)->first();
                if (!empty($check)) {
                    throw new \Exception("Obat $request->nama_obat sudah terdaftar");
                }

                $obat = Obat::create($data);
                if (!$obat->save()) {
                    throw new \Exception("Gagal menambahkan data");
                }
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
        $data = Obat::findOrFail($id);

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

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $obat = Obat::findOrFail($request->id);

            if (!$obat->delete()) {
                throw new \Exception("Terjadi kesalahan saat menghapus data");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
