<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaturanController extends Controller
{
    public function index()
    {
        $title = "pengaturan";
        $data = Pengaturan::first();

        return view('back.pages.datamaster.pengaturan', compact('title', 'data'));
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $pengaturan = Pengaturan::first();

            $data = [
                "nama" => $request->nama,
                "alamat" => $request->alamat,
                "telepon" => $request->telepon,
                "email" => $request->email,
                "map" => $request->map,
                "nama_kontak" => $request->nama_kontak,
                "profile" => $request->profile,
            ];

            if ($pengaturan != null) {
                if (!$pengaturan->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data");
                }
            } else {
                $pengaturan = Pengaturan::create($data);
                if (!$pengaturan->save()) {
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
}
