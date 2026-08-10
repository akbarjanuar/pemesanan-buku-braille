<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan Tampilan Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses Pendaftaran Akun
    public function register(Request $request)
    {
        // 1. Validasi Input + Pesan Custom
        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'nomor_telepon' => 'required|string|max:20',
            'alamat'        => 'nullable|string',
            'kata_sandi'    => 'required|string|min:8|confirmed',
            'foto_ktp'      => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'kata_sandi.min'       => 'Kata sandi harus terdiri dari minimal 8 karakter.',
            'kata_sandi.required'  => 'Kata sandi wajib diisi.',
            'kata_sandi.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'foto_ktp.required'    => 'Foto KTP wajib diunggah.',
            'foto_ktp.max'         => 'Ukuran foto KTP maksimal 2MB.',
        ]);

        // 2. Upload Foto KTP
        $pathFotoKtp = null;
        if ($request->hasFile('foto_ktp')) {
            $file = $request->file('foto_ktp');
            $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/ktp'), $namaFile);
            $pathFotoKtp = 'uploads/ktp/' . $namaFile;
        }

        // 3. Simpan Data ke Database
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
            'kata_sandi' => Hash::make($request->kata_sandi),
            'foto_ktp' => $pathFotoKtp,
        ]);

        // 4. Otomatis Login
        Auth::login($user);

        return redirect('/login')->with('success', 'Pendaftaran berhasil!');
    }

    // Menampilkan Tampilan Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses Autentikasi Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'kata_sandi' => 'required',
        ]);

        // Memetakan input 'kata_sandi' ke mekanisme autentikasi Laravel
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['kata_sandi']])) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Berhasil masuk!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang dimasukkan salah.',
        ])->onlyInput('email');
    }
}