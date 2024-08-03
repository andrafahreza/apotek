<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile_admin()
    {
        $title = "profile";

        return view('back.pages.profile', compact('title'));
    }

    public function simpan_profile_admin(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = [
                "name" => $request->name,
                "email" => $request->email,
                "telepon" => $request->telepon,
                "jenis_kelamin" => $request->jenis_kelamin,
                "alamat" => $request->alamat,
            ];

            $user = Auth::user();

            if (!$user->update($data)) {
                throw new \Exception("Terjadi kesalahan dalam menyimpan data");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil update data profil");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function ganti_password(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $checkOldPassword = Hash::check($request->old_password, $user->password);
            if (!$checkOldPassword) {
                throw new \Exception("Password lama salah");
            }

            if ($request->new_password != $request->konfirmasi_password) {
                throw new \Exception("Password baru dan konfirmasi password harus sama");
            }

            $user->password = Hash::make($request->new_password);

            if (!$user->update()) {
                throw new \Exception("Terjadi kesalahan saat memperbarui password");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil memperbarui password");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
