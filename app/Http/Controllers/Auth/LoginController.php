<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse ;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            if ($request->expectsJson()) {
                $token = $user->createToken('MyApp')->accessToken;
                return response()->json(['token' => $token]);
            } else {
                if ($user->is_admin == 1) {
                    return redirect()->route('admin.home')->with('success', 'Anda berhasil login sebagai admin!');
                } else {
                    return redirect()->route('home')->with('success', 'Anda berhasil login!');
                }
            }
        }
    
        return response()->json([
            'status' => 'error',
            'code' => 401,
            'message' => 'Login Gagal. Email atau Password salah.',
        ], 401);
    }

}
