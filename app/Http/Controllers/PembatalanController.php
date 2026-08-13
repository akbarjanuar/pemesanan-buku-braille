<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembatalanController extends Controller
{
    // Tampilkan halaman konfirmasi pembatalan
    public function konfirmasi($id)
    {
        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Cegah batalkan pesanan yang sudah dikirim/sampai/dibatalkan
        if (!in_array($pesanan->status, ['Diproses', 'Menunggu Diproses'])) {
            return redirect('/pesanan-saya');
        }

        return view('pesanan.batalkan', compact('pesanan'));
    }

    // Proses pembatalan
    public function proses(Request $request, $id)
    {
        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!in_array($pesanan->status, ['Diproses', 'Menunggu Diproses'])) {
            return redirect('/pesanan-saya');
        }

        $request->validate([
            'alasan' => 'required|string',
            'alasan_lainnya' => 'required_if:alasan,Alasan lainnya|nullable|string|max:500',
        ]);

        $alasanFinal = $request->alasan === 'Alasan lainnya'
            ? $request->alasan_lainnya
            : $request->alasan;

        $pesanan->update([
            'status' => 'Dibatalkan',
            'alasan_pembatalan' => $alasanFinal,
        ]);

        return redirect('/pesanan-saya');
    }
}