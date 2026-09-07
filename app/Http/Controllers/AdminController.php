<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Buku;
use App\Models\Pencetakan;

class AdminController extends Controller
{

    // =====================================================
    // ===== HALAMAN DASHBOARD =============================
    // =====================================================

    public function dashboard()
    {
        // Menghitung statistik berdasarkan status pesanan
        // Menggunakan whereIn untuk mengatasi variasi penulisan status (lama vs baru)
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

        // Mengambil 5 pesanan terbaru
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

        // Jika ada filter status dari dropdown
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

        // Memperbarui status semua pesanan yang diceklis
        \App\Models\Pesanan::whereIn('id', $request->ids)->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui!']);
    }


    // =====================================================
    // ===== HALAMAN DETAIL PESANAN ========================
    // =====================================================

    public function detailPesanan($id)
    {
        // Mengambil pesanan beserta user dan detail buku
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
        
        // 1. Ambil data user, hitung jumlah pesanan, dan FILTER hanya pelanggan
        $query = \App\Models\User::withCount('pesanan')->where('role', 'user');
        
        // 2. Fitur Pencarian
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
        // Ambil data user
        $pelanggan = \App\Models\User::findOrFail($id);
        
        // Ambil riwayat pesanan milik user ini
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
        // Mengambil data proses pencetakan dari tabel 'pencetakans' beserta relasinya
        $daftarPencetakan = Pencetakan::with([
            'pesanan.user',
            'pesanan.details.buku'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        $activeMenu = 'pencetakan';

        return view('admin.pencetakan', compact('daftarPencetakan', 'activeMenu'));
    }

    public function detailPencetakan()
    {
        // Implementasi untuk halaman detail pencetakan
        $activeMenu = 'pencetakan';
    }

    // ===== Halaman Kelola Buku =====
    public function kelolaBuku(Request $request)
    {
        // Fitur pencarian buku
        $search = $request->input('search');
        
        $query = Buku::query();
        
        if ($search) {
            // Menggunakan 'ilike' agar case-insensitive di Supabase (PostgreSQL)
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
            'tahun_terbit'    => 'nullable|date', // Menerima input tanggal dari form
            'deskripsi'       => 'nullable|string',
        ]);

        // Ambil tahunnya saja dari input tanggal lengkap
        $tahunTerbit = $request->tahun_terbit ? date('Y', strtotime($request->tahun_terbit)) : null;

        // Buat warna cover acak agar tampilan tabel menarik (seperti di database)
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

    // ===== Halaman Profil Admin =====
    public function profile()
    {
        $activeMenu = 'profile';
        return view('admin.profile', compact('activeMenu'));
    }
    
}