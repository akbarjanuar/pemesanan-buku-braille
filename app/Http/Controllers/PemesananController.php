<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    // STEP 1: Tampilkan halaman pilih jenis pemesanan
    public function jenis()
    {
        $daftarKeranjang = Keranjang::with('buku')->where('user_id', Auth::id())->get();

        if ($daftarKeranjang->isEmpty()) {
            return redirect('/keranjang');
        }

        // Ambil jenis pemesanan yang sudah pernah dipilih (kalau user klik "Kembali")
        $jenisTerpilih = session('pemesanan.jenis_pesanan', 'Pribadi');

        return view('pemesanan.jenis', compact('daftarKeranjang', 'jenisTerpilih'));
    }

    // STEP 1 (submit): Simpan pilihan jenis pemesanan ke session, lanjut ke step 2
    public function simpanJenis(Request $request)
    {
        $request->validate([
            'jenis_pesanan' => 'required|in:Pribadi,Lembaga,Organisasi',
        ]);

        session(['pemesanan.jenis_pesanan' => $request->jenis_pesanan]);

        return redirect('/pemesanan/alamat');
    }

    // STEP 2: Tampilkan halaman alamat pengiriman
    public function alamat()
    {
        $daftarKeranjang = Keranjang::with('buku')->where('user_id', Auth::id())->get();

        if ($daftarKeranjang->isEmpty()) {
            return redirect('/keranjang');
        }

        // Kalau belum pilih jenis pemesanan, kembalikan ke step 1
        if (!session()->has('pemesanan.jenis_pesanan')) {
            return redirect('/pemesanan');
        }

        $jenisPesanan = session('pemesanan.jenis_pesanan');

        return view('pemesanan.alamat', compact('daftarKeranjang', 'jenisPesanan'));
    }

    // STEP 2 (submit): Simpan alamat, buat pesanan final, kosongkan keranjang
    public function simpan(Request $request)
    {
        $request->validate([
            'nama_penerima'  => 'required|string|max:255',
            'telepon'        => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'kecamatan'      => 'nullable|string|max:255',
            'kota'           => 'required|string|max:255',
            'provinsi'       => 'nullable|string|max:255',
            'kode_pos'       => 'nullable|string|max:10',
            'catatan'        => 'nullable|string',
        ]);

        $user_id = Auth::id();
        $keranjang = Keranjang::where('user_id', $user_id)->get();

        if ($keranjang->isEmpty()) {
            return redirect('/keranjang');
        }

        $jenisPesanan = session('pemesanan.jenis_pesanan', 'Pribadi');
        $nomor_pesanan = 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);

        $pesanan = Pesanan::create([
            'user_id'           => $user_id,
            'nomor_pesanan'     => $nomor_pesanan,
            'status'            => 'Menunggu Diproses',
            'jenis_pesanan'     => $jenisPesanan,
            'tanggal_pemesanan' => date('Y-m-d'),
            'nama_penerima'     => $request->nama_penerima,
            'telepon'           => $request->telepon,
            'alamat_lengkap'    => $request->alamat_lengkap,
            'kecamatan'         => $request->kecamatan,
            'kota'              => $request->kota,
            'provinsi'          => $request->provinsi,
            'kode_pos'          => $request->kode_pos,
            'catatan'           => $request->catatan,
        ]);

        foreach ($keranjang as $item) {
            PesananDetail::create([
                'pesanan_id' => $pesanan->id,
                'buku_id'    => $item->buku_id,
                'jumlah'     => $item->jumlah,
            ]);

            $buku = Buku::find($item->buku_id);
            if ($buku) {
                $buku->stok = max(0, $buku->stok - $item->jumlah);
                $buku->save();
            }
        }

        Keranjang::where('user_id', $user_id)->delete();
        session()->forget('pemesanan.jenis_pesanan');

        return redirect('/pesanan-saya');
    }
}