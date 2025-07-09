<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an admin login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Pastikan user memiliki role admin
            if ($user->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.suggestions.index'));
            } else {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Anda tidak memiliki izin akses admin.',
                ])->onlyInput('email');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Log the admin out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Show the admin registration form.
     * Hati-hati dengan method ini di production. Biasanya admin dibuat manual atau via seeder.
     */
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    /**
     * Handle an admin registration request.
     * Hati-hati dengan method ini di production.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'posisi' => ['nullable', 'string', 'max:255'], // <-- TAMBAHKAN VALIDASI INI
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'posisi' => $request->posisi, // <-- UBAH KE MENGAMBIL DARI REQUEST
            'role' => 'admin',
        ]);

        Auth::login($user);

        // UBAH REDIRECT INI KE HALAMAN LOGIN
        return redirect()->route('admin.login')->with('success', 'Akun admin berhasil dibuat. Silakan login.');
    }
}