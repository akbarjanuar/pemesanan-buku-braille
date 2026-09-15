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
use App\Models\Keranjang;

Route::get('/home', function () {
    return redirect('/');
});

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
        $daftarKategori = Buku::select('kategori')
            ->distinct()
            ->pluck('kategori');

        return view('home', compact('daftarBuku', 'daftarKategori'));
    }

    return view('pemilihan-akun');
});

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register')
    ->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::get('/login-admin', [AuthController::class, 'showAdminLogin'])
    ->name('login.admin')
    ->middleware('guest');

Route::post('/login-admin', [AuthController::class, 'loginAdmin'])
    ->middleware('guest');

Route::get('/masuk', function () {
    return redirect('/');
});

Route::get('/buku/{id}', function ($id) {
    $buku = Buku::findOrFail($id);

    return view('detail', compact('buku'));
})->middleware('auth');

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

Route::get('/pemesanan', [PemesananController::class, 'jenis'])
    ->middleware('auth');

Route::post('/pemesanan/jenis', [PemesananController::class, 'simpanJenis'])
    ->middleware('auth');

Route::get('/pemesanan/alamat', [PemesananController::class, 'alamat'])
    ->middleware('auth');

Route::post('/pemesanan/simpan', [PemesananController::class, 'simpan'])
    ->middleware('auth');

Route::get('/pesanan-saya', function () {
    $daftarPesanan = Pesanan::with('details.buku')
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('pesanan', compact('daftarPesanan'));
})->middleware('auth');

Route::get('/pesanan/{id}', function ($id) {
    $pesanan = Pesanan::with('details.buku')
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    return view('pesanan.detail-pesanan', compact('pesanan'));
})->middleware('auth');

Route::get('/pesanan/{id}/batalkan', [PembatalanController::class, 'konfirmasi'])
    ->middleware('auth');

Route::post('/pesanan/{id}/batalkan', [PembatalanController::class, 'proses'])
    ->middleware('auth');


// =====================================================
// ===== ROUTE KHUSUS ADMIN ============================
// =====================================================

Route::middleware(['auth', AdminMiddleware::class])->group(function () {

    // Pintu Masuk Utama Admin
    Route::get('/admin/dashboard', [AdminController::class, 'redirectDashboardAdmin'])
        ->name('admin.dashboard');


    // =================================================
    // ===== ADMIN LITERASI DIGITAL ====================
    // =================================================

    Route::get('/admin/digital/dashboard', [AdminController::class, 'dashboardLiterasiDigital'])
        ->name('admin.digital.dashboard');

    Route::get('/admin/digital/pencetakan', [AdminController::class, 'semuaPencetakanDigital'])
        ->name('admin.digital.pencetakan');

    Route::post('/admin/digital/pencetakan/update/{id}', [AdminController::class, 'updateProgressDigital'])
        ->name('admin.digital.pencetakan.update');

    Route::get('/admin/digital/pic', function () {
        return view('admin.digital.pic');
    })->name('admin.digital.pic');


    // =================================================
    // ===== ADMIN PENGIRIMAN ==========================
    // =================================================

    Route::get('/admin/pengiriman/dashboard', [AdminController::class, 'dashboardPengiriman'])
        ->name('admin.pengiriman.dashboard');


    // =================================================
    // ===== MENU PENDUKUNG ADMIN ======================
    // =================================================

    Route::get('/admin/permintaan-buku', [AdminController::class, 'permintaanBuku'])
        ->name('admin.permintaan-buku');

    Route::post('/admin/permintaan-buku/update-status', [AdminController::class, 'updateStatusPesanan'])
        ->name('admin.permintaan-buku.update-status');

    Route::get('/admin/pesanan/{id}', [AdminController::class, 'detailPesanan'])
        ->name('admin.detail-pesanan');


    // =================================================
    // ===== KELOLA BUKU ===============================
    // =================================================

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


    // =================================================
    // ===== PENCETAKAN ================================
    // =================================================

    Route::get('/admin/pencetakan', [AdminController::class, 'pencetakan'])
        ->name('admin.pencetakan');

    Route::get('/admin/pencetakan/buat', [AdminController::class, 'buatPencetakan'])
        ->name('admin.buat-pencetakan');

    Route::post('/admin/pencetakan', [AdminController::class, 'storePencetakan'])
        ->name('admin.pencetakan.store');


    // =================================================
    // ===== DATA PELANGGAN ============================
    // =================================================

    Route::get('/admin/data-pelanggan', [AdminController::class, 'dataPelanggan'])
        ->name('admin.data-pelanggan');

    Route::get('/admin/data-pelanggan/{id}', [AdminController::class, 'detailPelanggan'])
        ->name('admin.detail-pelanggan');


    // =================================================
    // ===== PERMINTAAN BAHAN ==========================
    // =================================================

    Route::get('/admin/permintaan-bahan', [AdminController::class, 'permintaanBahan'])
        ->name('admin.permintaan-bahan');

    Route::post('/admin/permintaan-bahan/update', [AdminController::class, 'updateStatusBahan'])
        ->name('admin.permintaan-bahan.update-status');


    // =================================================
    // ===== LAPORAN ===================================
    // =================================================

    Route::get('/admin/laporan', [AdminController::class, 'laporan'])
        ->name('admin.laporan');


    // =================================================
    // ===== PROFILE ===================================
    // =================================================

    Route::get('/admin/profile', [AdminController::class, 'profile'])
        ->name('admin.profile');

    Route::put('/admin/profile', [AdminController::class, 'updateProfile'])
        ->name('admin.profile.update');

    Route::put('/admin/profile/notifikasi', [AdminController::class, 'updateNotifikasi'])
        ->name('admin.profile.notifikasi');


    // =================================================
    // ===== CETAK RESI ================================
    // =================================================

    Route::get('/admin/resi/cetak', function (Request $request) {
        $ids = array_filter(
            explode(',', $request->query('ids', ''))
        );

        if (empty($ids)) {
            abort(404, 'Tidak ada dokumen yang dipilih.');
        }

        $daftarPesanan = Pesanan::with('details.buku')
            ->whereIn('id', $ids)
            ->get();

        return view('admin.pengiriman.cetak-resi', compact('daftarPesanan'));
    });
});


Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
});