<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class AdminController extends Controller
{
    // ===== Halaman Dashboard =====
    public function dashboard()
    {
        // 1. Menghitung statistik berdasarkan kolom 'status' di tabel pesanans
        $stats = [
            'baru'                => Pesanan::where('status', 'Permintaan Baru')->count(),
            'diproses'            => Pesanan::where('status', 'Sedang Diproses')->count(),
            'menunggu_pencetakan' => Pesanan::where('status', 'Menunggu Pencetakan')->count(),
            'dicetak'             => Pesanan::where('status', 'Sedang Dicetak')->count(),
            'siap_dikirim'        => Pesanan::where('status', 'Siap Dikirim')->count(),
            'dikirim'             => Pesanan::where('status', 'Sedang Dikirim')->count(),
            'selesai'             => Pesanan::where('status', 'Selesai')->count(),
            'dibatalkan'          => Pesanan::where('status', 'Dibatalkan')->count(),
            'kendala'             => Pesanan::where('status', 'Kendala')->count(),
            'bahan_baru'          => Pesanan::where('status', 'Permintaan Bahan Baru')->count(),
        ];

        // 2. Mengambil 5 pesanan terbaru untuk tabel (butuh relasi ke tabel users untuk nama)
        $pesananTerbaru = Pesanan::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pesananTerbaru'));
    }

    // ===== Halaman Permintaan Buku =====
    public function permintaanBuku()
    {
        // Mengambil seluruh data pesanan beserta data user (pemesan), urutkan dari yang terbaru
        $daftarPesanan = Pesanan::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.permintaan-buku', compact('daftarPesanan'));
    }

    // ===== Halaman Detail Pesanan =====
    public function detailPesanan($id)
    {
        // Ambil data pesanan berdasarkan ID, beserta relasi user dan detail bukunya
        $pesanan = Pesanan::with(['user', 'details.buku'])->findOrFail($id);

        return view('admin.detail-pesanan', compact('pesanan'));
    }
}