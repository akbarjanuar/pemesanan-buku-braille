<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\Buku;
use App\Models\Pesanan;
use App\Models\Keranjang;

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

// Route Tambah ke Keranjang (HANYA JIKA sudah login)
Route::post('/keranjang/tambah/{buku_id}', function ($buku_id) {
    // Cek apakah buku sudah ada di keranjang user ini
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

    // Arahkan ke halaman keranjang setelah berhasil ditambah
    return redirect('/keranjang');
})->middleware('auth');

// Route Pesanan Saya (HANYA JIKA sudah login)
Route::get('/pesanan-saya', function () {
    // Mengambil data pesanan milik user yang sedang login beserta detail bukunya
    $daftarPesanan = Pesanan::with('details.buku')
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('pesanan', compact('daftarPesanan'));
})->middleware('auth');

// Route Halaman Keranjang (HANYA JIKA sudah login)
Route::get('/keranjang', function () {
    // Ambil data keranjang milik user yang login beserta relasi bukunya
    $daftarKeranjang = Keranjang::with('buku')->where('user_id', Auth::id())->get();
    return view('keranjang', compact('daftarKeranjang'));
})->middleware('auth');

// Route Checkout (HANYA JIKA sudah login)
Route::post('/checkout', function (Request $request) {
    $user_id = Auth::id();
    $keranjang = Keranjang::where('user_id', $user_id)->get();

    // Jika keranjang kosong, kembalikan ke halaman keranjang
    if ($keranjang->isEmpty()) {
        return redirect('/keranjang');
    }

    // 1. Buat Pesanan Baru
    // Membuat nomor unik, contoh: ORD-2026-0807-1234
    $nomor_pesanan = 'ORD-' . date('Y-md') . '-' . rand(1000, 9999); 
    
    $pesanan = Pesanan::create([
        'user_id' => $user_id,
        'nomor_pesanan' => $nomor_pesanan,
        'status' => 'Menunggu Diproses',
        'jenis_pesanan' => 'Pribadi',
        'tanggal_pemesanan' => date('Y-m-d'),
    ]);

    // 2. Pindahkan data Keranjang ke Pesanan Detail
    foreach ($keranjang as $item) {
        \App\Models\PesananDetail::create([
            'pesanan_id' => $pesanan->id,
            'buku_id' => $item->buku_id,
            'jumlah' => $item->jumlah
        ]);
        
        // (Opsional) Kurangi stok buku di database
        $buku = \App\Models\Buku::find($item->buku_id);
        if ($buku) {
            $buku->stok = $buku->stok - $item->jumlah;
            $buku->save();
        }
    }

    // 3. Kosongkan Keranjang setelah checkout berhasil
    Keranjang::where('user_id', $user_id)->delete();

    // Arahkan ke halaman Pesanan Saya
    return redirect('/pesanan-saya');
})->middleware('auth');

// Route Hapus Item dari Keranjang
Route::post('/keranjang/hapus/{id}', function ($id) {
    \App\Models\Keranjang::where('id', $id)->where('user_id', Auth::id())->delete();
    return redirect('/keranjang');
})->middleware('auth');

// Route Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});