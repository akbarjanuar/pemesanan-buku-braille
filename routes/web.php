<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PembatalanController; 
use App\Models\Buku;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Keranjang;

// Mengarahkan /home ke halaman utama / agar tidak error 404
Route::get('/home', function () {
    return redirect('/');
});

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

// Route Register (Hanya untuk tamu / belum login)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Route Login (Hanya untuk tamu / belum login)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

// Route Detail Buku (HANYA JIKA sudah login)
Route::get('/buku/{id}', function ($id) {
    $buku = Buku::findOrFail($id);
    return view('detail', compact('buku'));
})->middleware('auth');

// Route Tambah ke Keranjang (HANYA JIKA sudah login)
Route::post('/keranjang/tambah/{buku_id}', function ($buku_id) {
    $cekKeranjang = Keranjang::where('user_id', Auth::id())
                             ->where('buku_id', $buku_id)
                             ->first();

    if (!$cekKeranjang) {
        Keranjang::create([
            'user_id' => Auth::id(),
            'buku_id' => $buku_id,
            'jumlah' => 1
        ]);
    }

    return back();
})->middleware('auth');

// Route Halaman Keranjang (HANYA JIKA sudah login)
Route::get('/keranjang', function () {
    $daftarKeranjang = Keranjang::with('buku')->where('user_id', Auth::id())->get();
    return view('keranjang', compact('daftarKeranjang'));
})->middleware('auth');

// Route Hapus Item dari Keranjang
Route::post('/keranjang/hapus/{id}', function ($id) {
    Keranjang::where('id', $id)->where('user_id', Auth::id())->delete();
    return redirect('/keranjang');
})->middleware('auth');

// Route Checkout (HANYA JIKA sudah login)
// STEP 1: Pilih Jenis Pemesanan
Route::get('/pemesanan', [PemesananController::class, 'jenis'])->middleware('auth');
Route::post('/pemesanan/jenis', [PemesananController::class, 'simpanJenis'])->middleware('auth');

// STEP 2: Alamat Pengiriman
Route::get('/pemesanan/alamat', [PemesananController::class, 'alamat'])->middleware('auth');
Route::post('/pemesanan/simpan', [PemesananController::class, 'simpan'])->middleware('auth');

// Route Pesanan Saya (HANYA JIKA sudah login)
Route::get('/pesanan-saya', function () {
    $daftarPesanan = Pesanan::with('details.buku')
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('pesanan', compact('daftarPesanan'));
})->middleware('auth');

// Route Detail Pesanan
Route::get('/pesanan/{id}', function ($id) {
    $pesanan = Pesanan::with('details.buku')
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    return view('pesanan.detail-pesanan', compact('pesanan'));
})->middleware('auth');

// Route Batalkan Pesanan
Route::get('/pesanan/{id}/batalkan', [PembatalanController::class, 'konfirmasi'])->middleware('auth');
Route::post('/pesanan/{id}/batalkan', [PembatalanController::class, 'proses'])->middleware('auth');

// Route Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});