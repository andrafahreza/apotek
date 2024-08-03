<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index($search = null)
    {
        $title = "akun";
        $data = User::where(function($query) use($search) {
            if ($search != null) {
                $query->where('email', $search);
            }
        })
        ->latest()->get();

        return view('back.pages.menu.akun', compact('title', 'data'));
    }

    public function show($id = null)
    {
        $data = User::findOrFail($id);

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
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make('password'),
                "telepon" => $request->telepon,
                "jenis_kelamin" => $request->jenis_kelamin,
                "role" => $request->role,
                "alamat" => $request->alamat,
            ];

            if ($id != null) {
                $user = User::findOrFail($id);

                $check = User::where('email', $request->email)
                ->where('id', '!=', $id)
                ->first();

                if (!empty($check)) {
                    throw new \Exception("Akun $request->email sudah terdaftar");
                }

                if (!$user->update($data)) {
                    throw new \Exception("Terjadi kesalahan saat memperbarui data");
                }
            } else {
                $check = User::where('email', $request->email)->first();
                if (!empty($check)) {
                    throw new \Exception("Akun $request->email sudah terdaftar");
                }

                $user = User::create($data);
                if (!$user->save()) {
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
            $user = User::findOrFail($request->id);

            if (!$user->delete()) {
                throw new \Exception("Terjadi kesalahan saat menghapus data");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil menghapus data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function reset($id = null)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->password = Hash::make('password');

            if (!$user->update()) {
                throw new \Exception("Terjadi kesalahan saat mereset data");
            }

            DB::commit();

            return redirect()->back()->with("success", "Berhasil mereset data");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
