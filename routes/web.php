<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PembatalanController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Buku;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Keranjang;

// Redirect /home ke /
Route::get('/home', function () {
    return redirect('/');
});

// ===== HALAMAN UTAMA =====
Route::get('/', function (Request $request) {
    if (Auth::check()) {
        $query = Buku::query();

        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'ILIKE', "%{$keyword}%")
                  ->orWhere('pengarang', 'ILIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'Semua Kategori') {
            $query->where('kategori', $request->kategori);
        }

        $daftarBuku = $query->get();
        $daftarKategori = Buku::select('kategori')->distinct()->pluck('kategori');

        return view('home', compact('daftarBuku', 'daftarKategori'));
    }

    return view('pemilihan-akun');
});

// ===== ROUTE REGISTER =====
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register')
    ->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

// ===== ROUTE LOGIN PELANGGAN =====
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login')
    ->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

// ===== ROUTE LOGIN ADMIN =====
Route::get('/login-admin', [AuthController::class, 'showAdminLogin'])
    ->name('login.admin')
    ->middleware('guest');
Route::post('/login-admin', [AuthController::class, 'loginAdmin'])
    ->middleware('guest');

// Redirect /masuk ke /
Route::get('/masuk', function () {
    return redirect('/');
});

// ===== ROUTE DETAIL BUKU =====
Route::get('/buku/{id}', function ($id) {
    $buku = Buku::findOrFail($id);
    return view('detail', compact('buku'));
})->middleware('auth');

// ===== ROUTE KERANJANG =====
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

Route::get('/keranjang', function () {
    $daftarKeranjang = Keranjang::with('buku')
        ->where('user_id', Auth::id())
        ->get();

    return view('keranjang', compact('daftarKeranjang'));
})->middleware('auth');

Route::post('/keranjang/hapus/{id}', function ($id) {
    Keranjang::where('id', $id)
        ->where('user_id', Auth::id())
        ->delete();

    return redirect('/keranjang');
})->middleware('auth');

Route::post('/keranjang/update/{id}/{aksi}', function ($id, $aksi) {
    $item = Keranjang::where('id', $id)
        ->where('user_id', Auth::id())
        ->first();

    if ($item) {
        if ($aksi === 'tambah') {
            $item->jumlah += 1;
            $item->save();
        } elseif ($aksi === 'kurang') {
            if ($item->jumlah > 1) {
                $item->jumlah -= 1;
                $item->save();
            } else {
                $item->delete();
            }
        }
    }

    return redirect('/keranjang');
})->middleware('auth');

// ===== ROUTE PEMESANAN =====
Route::get('/pemesanan', [PemesananController::class, 'jenis'])
    ->middleware('auth');
Route::post('/pemesanan/jenis', [PemesananController::class, 'simpanJenis'])
    ->middleware('auth');

Route::get('/pemesanan/alamat', [PemesananController::class, 'alamat'])
    ->middleware('auth');
Route::post('/pemesanan/simpan', [PemesananController::class, 'simpan'])
    ->middleware('auth');

// ===== PESANAN SAYA =====
Route::get('/pesanan-saya', function () {
    $daftarPesanan = Pesanan::with('details.buku')
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('pesanan', compact('daftarPesanan'));
})->middleware('auth');

// ===== DETAIL PESANAN PELANGGAN =====
Route::get('/pesanan/{id}', function ($id) {
    $pesanan = Pesanan::with('details.buku')
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    return view('pesanan.detail-pesanan', compact('pesanan'));
})->middleware('auth');

// ===== BATALKAN PESANAN =====
Route::get('/pesanan/{id}/batalkan', [PembatalanController::class, 'konfirmasi'])
    ->middleware('auth');
Route::post('/pesanan/{id}/batalkan', [PembatalanController::class, 'proses'])
    ->middleware('auth');

// =====================================================
// ===== ROUTE KHUSUS ADMIN ============================
// =====================================================
Route::middleware(['auth', AdminMiddleware::class])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Permintaan Buku
    Route::get('/admin/permintaan-buku', [AdminController::class, 'permintaanBuku'])
        ->name('admin.permintaan-buku');
    Route::post('/admin/permintaan-buku/update-status', [AdminController::class, 'updateStatusPesanan'])
        ->name('admin.permintaan-buku.update-status');

    // Detail Pesanan Admin
    Route::get('/admin/pesanan/{id}', [AdminController::class, 'detailPesanan'])
        ->name('admin.detail-pesanan');

    // Kelola Buku
    Route::get('/admin/kelola-buku', [AdminController::class, 'kelolaBuku'])
        ->name('admin.kelola-buku');
    Route::get('/admin/kelola-buku/tambah', [AdminController::class, 'createBuku'])
        ->name('admin.tambah-buku');
    Route::post('/admin/kelola-buku/tambah', [AdminController::class, 'storeBuku'])
        ->name('admin.store-buku');
    Route::get('/admin/kelola-buku/{id}/edit', [AdminController::class, 'editBuku'])
        ->name('admin.edit-buku');
    Route::put('/admin/kelola-buku/{id}', [AdminController::class, 'updateBuku'])
        ->name('admin.update-buku');

    // ===== PENCETAKAN =====
    Route::get('/admin/pencetakan', [AdminController::class, 'pencetakan'])
        ->name('admin.pencetakan');

    Route::get('/admin/pencetakan/detail', [AdminController::class, 'detailPencetakan'])
        ->name('admin.detail-pencetakan');

    // Halaman Buat Permintaan Pencetakan
    Route::get('/admin/pencetakan/buat', [AdminController::class, 'buatPencetakan'])
        ->name('admin.buat-pencetakan');

    // ✅ DIPERBAIKI: Proses simpan permintaan pencetakan sekarang memanggil controller,
    // bukan closure kosong yang cuma redirect tanpa menyimpan apa pun.
    Route::post('/admin/pencetakan', [AdminController::class, 'storePencetakan'])
        ->name('admin.pencetakan.store');

    // Data Pelanggan
    Route::get('/admin/data-pelanggan', [AdminController::class, 'dataPelanggan'])
        ->name('admin.data-pelanggan');
    Route::get('/admin/data-pelanggan/{id}', [AdminController::class, 'detailPelanggan'])
        ->name('admin.detail-pelanggan');

    Route::get('/admin/laporan', function () {
    return view('admin.laporan');
    })->middleware('auth');    

    // ===== PROFILE ADMIN =====
    Route::get('/admin/profile', [AdminController::class, 'profile'])
        ->name('admin.profile');

    Route::put('/admin/profile', [AdminController::class, 'updateProfile'])
        ->name('admin.profile.update');

    // ===== UPDATE NOTIFIKASI ADMIN =====
    Route::put('/admin/profile/notifikasi', [AdminController::class, 'updateNotifikasi'])
        ->name('admin.profile.notifikasi');   

    // Pastikan route laporan ini ada di dalam file web.php
    Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');

});

// ===== LOGOUT =====
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});