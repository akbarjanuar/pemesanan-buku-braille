<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Buku;
use App\Models\Pencetakan;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    // =====================================================
    // ===== HALAMAN DASHBOARD =============================
    // =====================================================

    public function dashboard()
    {
        $stats = [
            'baru' => Pesanan::where('status', 'Permintaan Baru')->count(),
            'diproses' => Pesanan::whereIn('status', ['Diproses', 'Sedang Diproses'])->count(),
            'menunggu_pencetakan' => Pesanan::where('status', 'Menunggu Pencetakan')->count(),
            'dicetak' => Pesanan::whereIn('status', ['Dicetak', 'Sedang Dicetak'])->count(),
            'siap_dikirim' => Pesanan::where('status', 'Siap Dikirim')->count(),
            'dikirim' => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim'])->count(),
            'selesai' => Pesanan::where('status', 'Selesai')->count(),
            'dibatalkan' => Pesanan::where('status', 'Dibatalkan')->count(),
            'kendala' => Pesanan::where('status', 'Kendala')->count(),
            'bahan_baru' => Pesanan::where('status', 'Permintaan Bahan Baru')->count(),
        ];

        $pesananTerbaru = Pesanan::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $activeMenu = 'dashboard';

        return view('admin.dashboard', compact('stats', 'pesananTerbaru', 'activeMenu'));
    }


    // ===== Halaman Permintaan Buku =====
    public function permintaanBuku(Request $request)
    {
        $statusFilter = $request->input('status');

        $query = \App\Models\Pesanan::with('user')->orderBy('created_at', 'desc');

        if ($statusFilter && $statusFilter !== 'semua') {
            $query->where('status', $statusFilter);
        }

        $daftarPesanan = $query->get();
        $activeMenu = 'permintaan-buku';

        return view('admin.permintaan-buku', compact('daftarPesanan', 'statusFilter', 'activeMenu'));
    }

    // ===== Proses Update Status Massal =====
    public function updateStatusPesanan(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'status' => 'required|string'
        ]);

        $statusBaru = $request->status;

        \App\Models\Pesanan::whereIn('id', $request->ids)->update([
            'status' => $statusBaru
        ]);

        $admin = auth()->user();
        $notif = $admin->notif_settings ?? [];

        if (($statusBaru === 'Dicetak' || $statusBaru === 'Sedang Dicetak') && isset($notif['update_pencetakan']) && $notif['update_pencetakan']) {
            Log::info("Notifikasi: Update Pencetakan aktif untuk admin {$admin->nama}");
        } 
        elseif ($statusBaru === 'Selesai' && isset($notif['pesanan_diterima']) && $notif['pesanan_diterima']) {
            Log::info("Notifikasi: Pesanan Telah Diterima aktif untuk admin {$admin->nama}");
        } 
        elseif ($statusBaru === 'Dibatalkan' && isset($notif['pembatalan_pesanan']) && $notif['pembatalan_pesanan']) {
            Log::info("Notifikasi: Pembatalan Pesanan aktif untuk admin {$admin->nama}");
        }

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui!']);
    }


    // =====================================================
    // ===== HALAMAN DETAIL PESANAN ========================
    // =====================================================

    public function detailPesanan($id)
    {
        $pesanan = Pesanan::with([
            'user',
            'details.buku'
        ])->findOrFail($id);

        $activeMenu = 'permintaan-buku';

        return view('admin.detail-pesanan', compact('pesanan', 'activeMenu'));
    }

    // ===== Halaman Data Pelanggan =====
    public function dataPelanggan(Request $request)
    {
        $search = $request->input('search');
        
        $query = \App\Models\User::withCount('pesanan')->where('role', 'user');
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'ilike', "%{$search}%")
                  ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        $daftarPelanggan = $query->orderBy('created_at', 'desc')->get();
        $activeMenu = 'data-pelanggan';

        return view('admin.data-pelanggan', compact('daftarPelanggan', 'search', 'activeMenu'));
    }

    // ===== Halaman Detail Pelanggan =====
    public function detailPelanggan($id)
    {
        $pelanggan = \App\Models\User::findOrFail($id);
        
        $daftarPesanan = \App\Models\Pesanan::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $activeMenu = 'data-pelanggan';

        return view('admin.data-pelanggan-detail', compact('pelanggan', 'daftarPesanan', 'activeMenu'));
    }


    // =====================================================
    // ===== HALAMAN PENCETAKAN ============================
    // =====================================================

    public function pencetakan()
    {
        $daftarPencetakan = Pencetakan::with([
            'pesanan.user',
            'pesanan.details.buku'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        $activeMenu = 'pencetakan';

        return view('admin.pencetakan', compact('daftarPencetakan', 'activeMenu'));
    }

    public function buatPencetakan()
    {
        $daftarPesanan = Pesanan::with('user', 'details.buku')
            ->whereIn('status', ['Dicetak', 'Sedang Dicetak'])
            ->orderBy('created_at', 'desc')
            ->get();

        $daftarBuku = Buku::orderBy('judul')->get();

        $activeMenu = 'pencetakan';

        return view('admin.buat-pencetakan', compact('daftarPesanan', 'daftarBuku', 'activeMenu'));
    }

    public function detailPencetakan()
    {
        $activeMenu = 'pencetakan';
    }

    // ===== Halaman Kelola Buku =====
    public function kelolaBuku(Request $request)
    {
        $search = $request->input('search');
        
        $query = Buku::query();
        
        if ($search) {
            $query->where('judul', 'ilike', "%{$search}%")
                  ->orWhere('pengarang', 'ilike', "%{$search}%");
        }

        $daftarBuku = $query->orderBy('created_at', 'desc')->get();
        $activeMenu = 'kelola-buku';

        return view('admin.kelola-buku', compact('daftarBuku', 'search', 'activeMenu'));
    }

    // ===== Halaman Edit Buku =====
    public function editBuku($id)
    {
        $buku = Buku::findOrFail($id);
        $activeMenu = 'kelola-buku';
        
        return view('admin.edit-buku', compact('buku', 'activeMenu'));
    }

    // ===== Proses Update Buku =====
    public function updateBuku(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        
        $request->validate([
            'judul'           => 'required|string|max:255',
            'pengarang'       => 'required|string|max:255',
            'kategori'        => 'required|string|max:255',
            'penerbit'        => 'nullable|string|max:255',
            'stok'            => 'required|integer|min:0',
            'batas_pemesanan' => 'required|integer|min:1',
            'isbn'            => 'nullable|string|max:50',
            'tahun_terbit'    => 'nullable|string|max:4',
            'deskripsi'       => 'nullable|string',
        ]);

        $buku->update($request->all());

        return redirect()->route('admin.kelola-buku')->with('success', 'Data buku berhasil diperbarui!');
    }

    // ===== Halaman Tambah Buku =====
    public function createBuku()
    {
        $activeMenu = 'kelola-buku';
        return view('admin.tambah-buku', compact('activeMenu'));
    }

    // ===== Proses Simpan Buku Baru =====
    public function storeBuku(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'pengarang'       => 'required|string|max:255',
            'kategori'        => 'required|string|max:255',
            'penerbit'        => 'nullable|string|max:255',
            'stok'            => 'required|integer|min:0',
            'batas_pemesanan' => 'required|integer|min:1',
            'isbn'            => 'nullable|string|max:50',
            'tahun_terbit'    => 'nullable|date',
            'deskripsi'       => 'nullable|string',
        ]);

        $tahunTerbit = $request->tahun_terbit ? date('Y', strtotime($request->tahun_terbit)) : null;

        $colors = ['#0288d1', '#7b1fa2', '#2e7d32', '#455a64', '#ff5722', '#e64a19', '#d32f2f', '#388e3c'];
        $randomColor = $colors[array_rand($colors)];

        Buku::create([
            'judul'           => $request->judul,
            'pengarang'       => $request->pengarang,
            'kategori'        => $request->kategori,
            'penerbit'        => $request->penerbit,
            'stok'            => $request->stok,
            'batas_pemesanan' => $request->batas_pemesanan,
            'isbn'            => $request->isbn,
            'tahun_terbit'    => $tahunTerbit,
            'deskripsi'       => $request->deskripsi,
            'warna_cover'     => $randomColor,
        ]);
        

        return redirect()->route('admin.kelola-buku')->with('success', 'Buku baru berhasil ditambahkan!');
    }

    // =====================================================
    // ===== HALAMAN PROFILE ADMIN =========================
    // =====================================================

    public function profile()
    {
        $activeMenu = 'profile';
        return view('admin.profile', compact('activeMenu'));
    }

    // ===== Proses Update Profile Admin =====
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        \App\Models\User::where('id', $user->id)->update([
            'nama'          => $request->nama,
            'email'         => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return redirect()->back()->with('success', 'Informasi pribadi berhasil diperbarui!');
    }

    // ===== Proses Update Pengaturan Notifikasi =====
    public function updateNotifikasi(Request $request)
    {
        $user = auth()->user();

        $settings = $request->input('settings', []);

        $user->notif_settings = $settings;
        $user->save();

        return response()->json([
            'success' => true, 
            'message' => 'Pengaturan notifikasi berhasil diperbarui!'
        ]);
    }

    // ===== Proses Simpan Permintaan Pencetakan =====
    public function storePencetakan(Request $request)
    {
    $request->validate([
        'pesanan_id'     => 'required|exists:pesanan,id',
        'buku_id'        => 'required|exists:buku,id',
        'jumlah'         => 'required|integer|min:1',
        'divisi'         => 'required|string',
        'target_selesai' => 'required|date',
        'pic'            => 'required|string',
        'catatan'        => 'nullable|string',
    ]);

    // Buat kode cetak unik
    $kodeCetak = 'PRNT-' . date('Ymd') . '-' . rand(1000, 9999);

    // Simpan data secara lengkap ke tabel pencetakans di Supabase
    Pencetakan::create([
        'pesanan_id'     => $request->pesanan_id,
        'buku_id'        => $request->buku_id,
        'kode_cetak'     => $kodeCetak,
        'jumlah'         => $request->jumlah,
        'divisi'         => $request->divisi,
        'jenis_literasi' => $request->divisi, 
        'target_buku'    => $request->jumlah,  
        'deadline'       => $request->target_selesai, 
        'pic'            => $request->pic,
        'catatan'        => $request->catatan,
        'status'         => 'Menunggu Diproses',
    ]);

    // Cek pengaturan notifikasi admin untuk "Update Pencetakan"
    $admin = auth()->user();
    $notif = $admin->notif_settings ?? [];
    if (isset($notif['update_pencetakan']) && $notif['update_pencetakan']) {
        Log::info("Notifikasi: Permintaan pencetakan baru berhasil dibuat oleh {$admin->nama}");
    }

    return redirect()->route('admin.pencetakan')->with('success', 'Permintaan pencetakan baru berhasil dibuat.');
    }
    
}