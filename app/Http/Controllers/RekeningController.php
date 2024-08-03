<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekeningController extends Controller
{
    public function index()
    {
        $title = "rekening";
        $data = Rekening::latest()->get();

        return view('back.pages.datamaster.rekening', compact('title', 'data'));
    }

    public function show($id = null)
    {
        $data = Rekening::findOrFail($id);

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

    public function simpan(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $data = [
                "nama_rekening" => $request->nama_rekening,
                "no_rekening" => $request->no_rekening,
                "atas_nama" => $request->atas_nama,
            ];

            if ($id != null) {
                $rekening = Rekening::findOrFail($id);

                $check = Rekening::where('no_rekening', $request->no_rekening)
                ->where('id', '!=', $id)
                ->first();

                if (!empty($check)) {
                    throw new \Exception("Rekening $request->no_rekening sudah terdaftar");
                }

                if (!$rekening->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data");
                }
            } else {
                $check = Rekening::where('no_rekening', $request->no_rekening)->first();
                if (!empty($check)) {
                    throw new \Exception("Rekening $request->no_rekening sudah terdaftar");
                }

                $rekening = Rekening::create($data);
                if (!$rekening->save()) {
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

    public function hapus(Request $request)
    {
        DB::beginTransaction();

        try {
            $rekening = Rekening::findOrFail($request->id);

            if (!$rekening->delete()) {
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
