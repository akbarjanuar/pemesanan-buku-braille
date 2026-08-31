<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;


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


    // =====================================================
    // ===== HALAMAN PENCETAKAN ============================
    // =====================================================

    public function pencetakan()
    {

        /*
        |----------------------------------------------------
        | Mengambil pesanan yang berkaitan dengan pencetakan
        |----------------------------------------------------
        |
        | Untuk sementara kita mengambil data berdasarkan
        | status yang berkaitan dengan proses pencetakan.
        |
        */

        $daftarPesanan = Pesanan::with([
            'user',
            'details.buku'
        ])
        ->whereIn('status', [
            'Menunggu Pencetakan',
            'Sedang Dicetak',
            'Selesai'
        ])
        ->orderBy('created_at', 'desc')
        ->get();


        return view(
            'admin.pencetakan',
            compact('daftarPesanan')
        );
    }

    public function detailPencetakan()
    {
        // Implementasi untuk halaman detail pencetakan
    }
}