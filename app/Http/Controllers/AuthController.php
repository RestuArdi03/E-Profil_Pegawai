<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Cache\RateLimiter;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // pastikan ada file resources/views/auth/login.blade.php
    }

    // Proses login
 public function login(Request $request)
    {
        $limiter = app(RateLimiter::class);
        $key = 'login:' . $request->ip();

        // 1️⃣ Cegah brute force: batas 5x percobaan
        if ($limiter->tooManyAttempts($key, 5)) {
            $seconds = $limiter->availableIn($key);
            return back()->with('loginError', "Terlalu banyak percobaan login. Coba lagi dalam $seconds detik.")
                        ->with('lockoutSeconds', $seconds);
        }

        // 2️⃣ Validasi input awal
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required',
        ]);

        // 3️⃣ Verifikasi token reCAPTCHA ke Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $body = $response->json();

        // Kalau gagal / score kecil
        if (!$body['success'] || ($body['score'] ?? 0) < 0.5) {
            $limiter->hit($key, 60); // tambah percobaan gagal
            return back()->with('loginError', 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
        }

        // 4️⃣ Hapus reCAPTCHA sebelum login ke DB
        unset($credentials['g-recaptcha-response']);

        // 5️⃣ Coba autentikasi user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role == 1) {
                return redirect()->route('backend.beranda');
            } elseif (Auth::user()->role == 6) {
                return redirect()->route('frontend.beranda');
            } else {
                return redirect()->route('login');
            }
        }

        // 6️⃣ Kalau gagal login → hit attempt
        $limiter->hit($key, 60);

        // 7️⃣ Kirim pesan gagal ke view
        return back()->with('loginError', 'Login gagal. Username atau password salah.');
    }


    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
