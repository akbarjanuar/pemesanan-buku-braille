<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'nomor_telepon' => 'required|string|max:20',
            'alamat'        => 'nullable|string',
            'kata_sandi'    => 'required|string|min:8|confirmed',
            'foto_ktp'      => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $pathFotoKtp = null;
        if ($request->hasFile('foto_ktp')) {
            $file = $request->file('foto_ktp');
            $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('s3')->put($namaFile, file_get_contents($file->getRealPath()), 'public');
            $pathFotoKtp = 'https://zvviugrtexqoegjxuxlc.supabase.co/storage/v1/object/public/ktp/' . $namaFile;
        }

        $user = User::create([
            'nama'          => $request->nama,
            'email'         => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat'        => $request->alamat,
            'kata_sandi'    => Hash::make($request->kata_sandi),
            'foto_ktp'      => $pathFotoKtp,
        ]);

        Auth::login($user);
        return redirect('/')->with('success', 'Pendaftaran berhasil! Selamat datang di BrailleKita.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'      => 'required|email',
            'kata_sandi' => 'required',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['kata_sandi']])) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Berhasil masuk!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang dimasukkan salah.',
        ])->onlyInput('email');
    }

    public function showAdminLogin()
    {
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email'      => 'required|email',
            'kata_sandi' => 'required',
        ], [
            'email.required'      => 'Alamat email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'kata_sandi.required' => 'Kata sandi wajib diisi.',
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['kata_sandi']])) {
            $user = auth()->user();

            if ($user->role === 'admin' || str_contains(strtolower($user->email), 'admin')) {
                $request->session()->regenerate();

                $divisi = strtolower($user->divisi ?? '');
                if ($divisi === 'pengiriman' || str_contains($divisi, 'kirim') || str_contains(strtolower($user->email), 'pengiriman')) {
                    return redirect()->route('admin.pengiriman.dashboard')
                        ->with('success', 'Selamat datang, Admin Pengiriman!');
                }

                return redirect()->route('admin.digital.dashboard')
                    ->with('success', 'Selamat datang, Admin Literasi Digital!');
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akses ditolak! Akun ini bukan akun Admin.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang dimasukkan salah.',
        ])->onlyInput('email');
    }
}