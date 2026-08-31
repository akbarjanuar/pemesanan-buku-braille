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
        $stats = [

            'baru' => Pesanan::where(
                'status',
                'Permintaan Baru'
            )->count(),

            'diproses' => Pesanan::where(
                'status',
                'Sedang Diproses'
            )->count(),

            'menunggu_pencetakan' => Pesanan::where(
                'status',
                'Menunggu Pencetakan'
            )->count(),

            'dicetak' => Pesanan::where(
                'status',
                'Sedang Dicetak'
            )->count(),

            'siap_dikirim' => Pesanan::where(
                'status',
                'Siap Dikirim'
            )->count(),

            'dikirim' => Pesanan::where(
                'status',
                'Sedang Dikirim'
            )->count(),

            'selesai' => Pesanan::where(
                'status',
                'Selesai'
            )->count(),

            'dibatalkan' => Pesanan::where(
                'status',
                'Dibatalkan'
            )->count(),

            'kendala' => Pesanan::where(
                'status',
                'Kendala'
            )->count(),

            'bahan_baru' => Pesanan::where(
                'status',
                'Permintaan Bahan Baru'
            )->count(),
        ];


        // Mengambil 5 pesanan terbaru
        $pesananTerbaru = Pesanan::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        return view(
            'admin.dashboard',
            compact(
                'stats',
                'pesananTerbaru'
            )
        );
    }


    // =====================================================
    // ===== HALAMAN PERMINTAAN BUKU =======================
    // =====================================================

    public function permintaanBuku()
    {

        // Mengambil seluruh pesanan beserta data user
        $daftarPesanan = Pesanan::with('user')
            ->orderBy('created_at', 'desc')
            ->get();


        return view(
            'admin.permintaan-buku',
            compact('daftarPesanan')
        );
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


        return view(
            'admin.detail-pesanan',
            compact('pesanan')
        );
    }

// ===== Halaman Data Pelanggan =====
    public function dataPelanggan(Request $request)
    {
        $search = $request->input('search');
        
        // 1. Ambil data user, hitung jumlah pesanan, dan FILTER hanya pelanggan
        // (Catatan: Sesuaikan 'pelanggan' dengan isi kolom role di database kamu. 
        // Jika menggunakan 'user', ganti jadi where('role', 'user'))
        $query = \App\Models\User::withCount('pesanan')->where('role', 'user');
        
        // 2. Fitur Pencarian
        if ($search) {
            // Gunakan function($q) agar 'orWhere' tidak merusak filter role di atas
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'ilike', "%{$search}%")
                  ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        $daftarPelanggan = $query->orderBy('created_at', 'desc')->get();

        return view('admin.data-pelanggan', compact('daftarPelanggan', 'search'));
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

        return view('admin.data-pelanggan-detail', compact('pelanggan', 'daftarPesanan'));
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

        return view(
            'admin.pencetakan',
            compact('daftarPencetakan')
        );
    }

    public function detailPencetakan()
    {
        // Implementasi untuk halaman detail pencetakan
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

        return view('admin.kelola-buku', compact('daftarBuku', 'search'));
    }

    // ===== Halaman Edit Buku =====
    public function editBuku($id)
    {
        $buku = Buku::findOrFail($id);
        
        return view('admin.edit-buku', compact('buku'));
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
        return view('admin.tambah-buku');
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
}