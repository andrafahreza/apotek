<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function regis(Request $request)
    {
        DB::beginTransaction();

        try {
            $checkEmail = User::where('email', $request->email)->first();
            if (!empty($checkEmail)) {
                throw new \Exception("Email $request->email sudah pernah digunakan");
            }

            $data = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "telepon" => $request->telepon,
                "jenis_kelamin" => $request->jenis_kelamin,
                "role" => "customer",
                "alamat" => $request->alamat,
            ];

            $user = User::create($data);

            if (!$user->save()) {
                throw new \Exception("Terjadi kesalahan, silahkan coba lagi");
            }

            DB::commit();

            return redirect()->route('login')->with("success", "Berhasil melakukan pendaftaran, silahkan login");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $th->getMessage()]);
        }
    }

    public function auth(Request $request)
    {
        try {
            $credentials = $request->validate([
                "email" => 'required',
                "password" => 'required'
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                if (Auth::user()->role != "customer") {
                    return redirect()->intended("home");
                } else {
                    return redirect()->intended('/');
                }
            }

            throw new \Exception("Email atau password salah");

        } catch (\Throwable $th) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->back()->withErrors(['message' => $th->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
