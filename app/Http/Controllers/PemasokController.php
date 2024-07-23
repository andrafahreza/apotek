<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemasokController extends Controller
{
    public function index($search = null)
    {
        $title = "pemasok";
        $data = Pemasok::where(function ($query) use ($search) {
            if ($search != null) {
                $query->where('nama_pemasok', 'like', "%$search%");
            }
        })
        ->latest()
        ->get();

        return view('back.pages.datamaster.pemasok', compact('title', 'data'));
    }

    public function simpan(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $data = [
                "nama_pemasok" => $request->nama_pemasok,
                "no_telp" => $request->no_telp,
                "alamat" => $request->alamat
            ];

            if ($id != null) {
                $pemasok = Pemasok::findOrFail($id);

                $check = Pemasok::where('nama_pemasok', $request->nama_pemasok)
                ->where('id', '!=', $id)
                ->first();

                if (!empty($check)) {
                    throw new \Exception("Pemasok $request->nama_pemasok sudah terdaftar");
                }

                if (!$pemasok->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data");
                }
            } else {
                $check = Pemasok::where('nama_pemasok', $request->nama_pemasok)->first();
                if (!empty($check)) {
                    throw new \Exception("Pemasok $request->nama_pemasok sudah terdaftar");
                }

                $pemasok = Pemasok::create($data);
                if (!$pemasok->save()) {
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
        $data = Pemasok::findOrFail($id);

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
            $pemasok = Pemasok::findOrFail($request->id);

            if (!$pemasok->delete()) {
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
