<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
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

    public function validasi_terima(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Pemesanan::findOrFail($request->id);
            $data->status = "diterima";

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
