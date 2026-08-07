<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\Buku;

// Mengarahkan ke halaman home dengan Fitur Cari & Filter Kategori (HANYA JIKA sudah login)
Route::get('/', function (Request $request) {
    $query = Buku::query();

    // 1. Fitur Cari Judul atau Pengarang (Menggunakan ILIKE khusus PostgreSQL)
    if ($request->filled('cari')) {
        $keyword = $request->cari;
        $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'ILIKE', "%{$keyword}%")
              ->orWhere('pengarang', 'ILIKE', "%{$keyword}%");
        });
    }

    // 2. Fitur Filter Kategori
    if ($request->filled('kategori') && $request->kategori !== 'Semua Kategori') {
        $query->where('kategori', $request->kategori);
    }

    // Eksekusi query untuk mendapatkan daftar buku yang sudah difilter
    $daftarBuku = $query->get();

    // Mengambil daftar kategori unik langsung dari database untuk dropdown
    $daftarKategori = Buku::select('kategori')->distinct()->pluck('kategori');

    return view('home', compact('daftarBuku', 'daftarKategori'));
})->middleware('auth');

// Route Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Route Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

// Route Detail Buku (HANYA JIKA sudah login)
Route::get('/buku/{id}', function ($id) {
    // Mencari buku berdasarkan ID, jika tidak ada akan memunculkan error 404
    $buku = App\Models\Buku::findOrFail($id);
    return view('detail', compact('buku'));
})->middleware('auth');

// Route Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});