<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
// Pastikan model Pesanan sudah berelasi dengan model User

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Menghitung statistik berdasarkan kolom 'status' di tabel pesanans
        // (Sesuaikan nama string status ini dengan yang kamu gunakan di database)
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
}