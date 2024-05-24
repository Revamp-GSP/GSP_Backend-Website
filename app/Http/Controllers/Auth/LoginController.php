<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validasi kredensial
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_admin == 1) {
                return redirect()->route('admin.home')->with('success', 'Anda berhasil login sebagai admin!');
            } elseif ($user->is_admin == 0) {
                Auth::logout(); // Logout pengguna jika bukan admin
                return redirect()->back()->with('error', "Anda tidak memiliki akses ke halaman ini.");
            }
            // Jika berhasil login, atur token
            $user->api_token = Str::random(60);
            $user->save();
        }

        // Jika kredensial tidak valid, tampilkan pesan error di halaman login
        throw ValidationException::withMessages([
            'email' => 'Login Gagal. Email atau Password salah.',
        ]);
    }
}
