<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Buku;
use App\Models\Pencetakan;
use App\Models\PermintaanBahan;
use App\Models\Pic;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function redirectDashboardAdmin()
    {
        $user = auth()->user();
        $divisi = strtolower($user->divisi ?? '');
        $email = strtolower($user->email ?? '');

        if ($divisi === 'pengiriman' || str_contains($divisi, 'kirim') || str_contains($email, 'pengiriman')) {
            return redirect()->route('admin.pengiriman.dashboard');
        } elseif ($divisi === 'literasi manual' || str_contains($divisi, 'manual') || str_contains($email, 'manual')) {
            return redirect()->route('admin.manual.dashboard');
        }

        return redirect()->route('admin.digital.dashboard');
    }

    // =====================================================
    // ADMIN PENGIRIMAN
    // =====================================================

    public function dashboardPengiriman()
    {
        $stats = [
            'baru'                => Pesanan::whereIn('status', ['Permintaan Baru', 'Permintaan baru', 'Baru'])->count(),
            'diproses'            => Pesanan::whereIn('status', ['Diproses', 'Sedang Diproses', 'Sedang diproses'])->count(),
            'menunggu_pencetakan' => Pesanan::whereIn('status', ['Menunggu Pencetakan', 'Menunggu pencetakan'])->count(),
            'dicetak'             => Pesanan::whereIn('status', ['Dicetak', 'Sedang Dicetak', 'Sedang dicetak'])->count(),
            'siap_dikirim'        => Pesanan::whereIn('status', ['Siap Dikirim', 'Siap dikirim'])->count(),
            'dikirim'             => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim', 'Sedang dikirim'])->count(),
            'selesai'             => Pesanan::whereIn('status', ['Selesai', 'selesai'])->count(),
            'dibatalkan'          => Pesanan::whereIn('status', ['Dibatalkan', 'Pesanan Dibatalkan', 'Batal'])->count(),
            'kendala'             => Pesanan::whereIn('status', ['Kendala', 'kendala'])->count(),
            'bahan_baru'          => PermintaanBahan::count(),
        ];

        $totalSiapDikirim = $stats['siap_dikirim'];
        $totalDikirim = $stats['dikirim'];

        $daftarPengiriman = Pesanan::with('user')
            ->whereIn('status', ['Siap Dikirim', 'Siap dikirim', 'Dikirim', 'Sedang Dikirim'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pesananTerbaru = Pesanan::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $activeMenu = 'dashboard-pengiriman';

        return view('admin.pengiriman.dashboard', compact(
            'stats',
            'totalSiapDikirim',
            'totalDikirim',
            'daftarPengiriman',
            'pesananTerbaru',
            'activeMenu'
        ));
    }

    public function permintaanBuku(Request $request)
    {
        $statusFilter = $request->input('status');
        $query = Pesanan::with('user')->orderBy('created_at', 'desc');

        if ($statusFilter && $statusFilter !== 'semua') {
            $query->where('status', $statusFilter);
        }

        $daftarPesanan = $query->get();
        $activeMenu = 'permintaan-buku';

        if (view()->exists('admin.pengiriman.permintaan-buku')) {
            return view('admin.pengiriman.permintaan-buku', compact(
                'daftarPesanan',
                'statusFilter',
                'activeMenu'
            ));
        }

        return view('admin.pengiriman.dashboard', [
            'totalSiapDikirim' => Pesanan::whereIn('status', ['Siap Dikirim', 'Siap dikirim'])->count(),
            'totalDikirim' => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim'])->count(),
            'daftarPengiriman' => $daftarPesanan,
            'pesananTerbaru' => Pesanan::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
            'activeMenu' => $activeMenu
        ]);
    }

    public function updateStatusPesanan(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'status' => 'required|string'
        ]);

        Pesanan::whereIn('id', $request->ids)->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui!'
        ]);
    }

    public function detailPesanan($id)
    {
        $pesanan = Pesanan::with(['user', 'details.buku'])->findOrFail($id);
        $activeMenu = 'permintaan-buku';

        if (view()->exists('admin.pengiriman.detail-pesanan')) {
            return view('admin.pengiriman.detail-pesanan', compact('pesanan', 'activeMenu'));
        }

        return view('admin.pengiriman.dashboard', [
            'totalSiapDikirim' => Pesanan::whereIn('status', ['Siap Dikirim', 'Siap dikirim'])->count(),
            'totalDikirim' => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim'])->count(),
            'daftarPengiriman' => Pesanan::with('user')->take(5)->get(),
            'pesananTerbaru' => Pesanan::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
            'activeMenu' => $activeMenu
        ]);
    }

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

        if (view()->exists('admin.pengiriman.data-pelanggan')) {
            return view('admin.pengiriman.data-pelanggan', compact('daftarPelanggan', 'search', 'activeMenu'));
        }

        return view('admin.pengiriman.dashboard', [
            'totalSiapDikirim' => Pesanan::whereIn('status', ['Siap Dikirim', 'Siap dikirim'])->count(),
            'totalDikirim' => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim'])->count(),
            'daftarPengiriman' => Pesanan::with('user')->take(5)->get(),
            'pesananTerbaru' => Pesanan::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
            'activeMenu' => $activeMenu
        ]);
    }

    public function detailPelanggan($id)
    {
        $pelanggan = \App\Models\User::findOrFail($id);
        $daftarPesanan = Pesanan::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        $activeMenu = 'data-pelanggan';

        if (view()->exists('admin.pengiriman.data-pelanggan-detail')) {
            return view('admin.pengiriman.data-pelanggan-detail', compact('pelanggan', 'daftarPesanan', 'activeMenu'));
        }

        return view('admin.pengiriman.dashboard', [
            'totalSiapDikirim' => Pesanan::whereIn('status', ['Siap Dikirim', 'Siap dikirim'])->count(),
            'totalDikirim' => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim'])->count(),
            'daftarPengiriman' => Pesanan::with('user')->take(5)->get(),
            'pesananTerbaru' => Pesanan::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
            'activeMenu' => $activeMenu
        ]);
    }

    public function pencetakan()
    {
        $daftarPencetakan = Pencetakan::with(['pesanan.user', 'pesanan.details.buku'])
            ->orderBy('created_at', 'desc')
            ->get();

        $activeMenu = 'pencetakan';

        if (view()->exists('admin.pengiriman.pencetakan')) {
            return view('admin.pengiriman.pencetakan', compact('daftarPencetakan', 'activeMenu'));
        }

        return view('admin.pengiriman.dashboard', [
            'totalSiapDikirim' => Pesanan::whereIn('status', ['Siap Dikirim', 'Siap dikirim'])->count(),
            'totalDikirim' => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim'])->count(),
            'daftarPengiriman' => Pesanan::with('user')->take(5)->get(),
            'pesananTerbaru' => Pesanan::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
            'activeMenu' => $activeMenu
        ]);
    }

    public function buatPencetakan()
    {
        $pesananSudahDiproses = Pencetakan::pluck('pesanan_id')->toArray();

        $daftarPesanan = Pesanan::with('user', 'details.buku')
            ->whereIn('status', ['Dicetak', 'Sedang Dicetak'])
            ->whereNotIn('id', $pesananSudahDiproses)
            ->orderBy('created_at', 'desc')
            ->get();

        $daftarBuku = Buku::orderBy('judul')->get();
        $activeMenu = 'pencetakan';

        if (view()->exists('admin.pengiriman.buat-pencetakan')) {
            return view('admin.pengiriman.buat-pencetakan', compact('daftarPesanan', 'daftarBuku', 'activeMenu'));
        }

        return view('admin.pengiriman.dashboard', [
            'totalSiapDikirim' => Pesanan::whereIn('status', ['Siap Dikirim', 'Siap dikirim'])->count(),
            'totalDikirim' => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim'])->count(),
            'daftarPengiriman' => Pesanan::with('user')->take(5)->get(),
            'pesananTerbaru' => Pesanan::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
            'activeMenu' => $activeMenu
        ]);
    }

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

        $kodeCetak = 'PRNT-' . date('Ymd') . '-' . rand(1000, 9999);

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

        return redirect()
            ->route('admin.pencetakan')
            ->with('success', 'Permintaan pencetakan baru berhasil dibuat.');
    }

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

        if (view()->exists('admin.pengiriman.kelola-buku')) {
            return view('admin.pengiriman.kelola-buku', compact('daftarBuku', 'search', 'activeMenu'));
        }

        return view('admin.pengiriman.dashboard', [
            'totalSiapDikirim' => Pesanan::whereIn('status', ['Siap Dikirim', 'Siap dikirim'])->count(),
            'totalDikirim' => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim'])->count(),
            'daftarPengiriman' => Pesanan::with('user')->take(5)->get(),
            'pesananTerbaru' => Pesanan::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
            'activeMenu' => $activeMenu
        ]);
    }

    public function profile()
    {
        $activeMenu = 'profile';

        if (view()->exists('admin.pengiriman.profile')) {
            return view('admin.pengiriman.profile', compact('activeMenu'));
        }

        return view('admin.pengiriman.dashboard', [
            'totalSiapDikirim' => Pesanan::whereIn('status', ['Siap Dikirim', 'Siap dikirim'])->count(),
            'totalDikirim' => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim'])->count(),
            'daftarPengiriman' => Pesanan::with('user')->take(5)->get(),
            'pesananTerbaru' => Pesanan::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
            'activeMenu' => $activeMenu
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'nomor_telepon' => 'nullable|string|max:20',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,JFIF|max:2048',
        ]);

        $dataUpdate = [
            'nama'          => $request->nama,
            'email'         => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
        ];

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storePubliclyAs('profile_fotos', $fileName, 'profile_storage');

            $endpoint = rtrim(env('AWS_ENDPOINT'), '/');
            $endpoint = str_replace('/storage/v1/s3', '', $endpoint);
            $bucket = env('AWS_BUCKET_PROFILE', 'profile');
            $fullUrl = "{$endpoint}/storage/v1/object/public/{$bucket}/{$path}";

            $dataUpdate['foto_profil'] = $fullUrl;
        }

        \App\Models\User::where('id', $user->id)->update($dataUpdate);

        return redirect()->back()->with('success', 'Informasi profil dan foto berhasil diperbarui!');
    }

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

    public function permintaanBahan(Request $request)
    {
        $statusFilter = $request->input('status', 'semua');
        $query = PermintaanBahan::with(['pencetakan.buku'])->orderBy('created_at', 'desc');

        if ($statusFilter !== 'semua') {
            if ($statusFilter == 'menunggu') {
                $query->where('status', 'like', '%Menunggu Tanda Tangan%');
            } elseif ($statusFilter == 'diproses') {
                $query->where(function ($q) {
                    $q->where('status', 'like', '%Menunggu diproses%')
                        ->orWhere('status', 'like', '%Menunggu Diproses%')
                        ->orWhere('status', 'like', '%Diproses%')
                        ->orWhere('status', 'like', '%Surat Dibuat%');
                });
            } elseif ($statusFilter == 'selesai') {
                $query->where('status', 'like', '%Selesai%');
            }
        }

        $permintaanBahan = $query->get();
        $activeMenu = 'permintaan-bahan';

        if (view()->exists('admin.pengiriman.permintaan-bahan')) {
            return view('admin.pengiriman.permintaan-bahan', compact('permintaanBahan', 'statusFilter', 'activeMenu'));
        }

        return view('admin.pengiriman.dashboard', [
            'totalSiapDikirim' => Pesanan::whereIn('status', ['Siap Dikirim', 'Siap dikirim'])->count(),
            'totalDikirim' => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim'])->count(),
            'daftarPengiriman' => Pesanan::with('user')->take(5)->get(),
            'pesananTerbaru' => Pesanan::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
            'activeMenu' => $activeMenu
        ]);
    }

    public function updateStatusBahan(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required|string',
            'kendala' => 'nullable|string'
        ]);

        $bahan = PermintaanBahan::findOrFail($request->id);

        if ($request->has('kendala') && !empty($request->kendala)) {
            $bahan->status = 'Kendala';
            $bahan->catatan_kendala = $request->kendala;
        } else {
            $bahan->status = $request->status;
        }

        $bahan->save();

        return redirect()->back()->with('success', 'Status permintaan bahan berhasil diperbarui!');
    }

    public function laporan(Request $request)
    {
        $range = $request->input('range', '6-bulan');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $queryStart = null;
        $queryEnd = \Carbon\Carbon::now()->endOfDay();

        if ($startDate && $endDate) {
            $queryStart = \Carbon\Carbon::parse($startDate)->startOfDay();
            $queryEnd = \Carbon\Carbon::parse($endDate)->endOfDay();
            $range = 'custom';
        } else {
            switch ($range) {
                case 'hari-ini':
                    $queryStart = \Carbon\Carbon::today();
                    break;
                case 'minggu-ini':
                    $queryStart = \Carbon\Carbon::now()->startOfWeek();
                    break;
                case 'bulan-ini':
                    $queryStart = \Carbon\Carbon::now()->startOfMonth();
                    break;
                case '6-bulan':
                default:
                    $queryStart = \Carbon\Carbon::now()->subMonths(6)->startOfDay();
                    break;
            }
        }

        $pesanans = Pesanan::with(['user', 'details.buku'])
            ->whereBetween('created_at', [$queryStart, $queryEnd])
            ->orderBy('created_at', 'desc')
            ->get();

        $bukus = Buku::orderBy('judul')->get();

        $pencetakans = Pencetakan::with(['pesanan.user', 'buku'])
            ->whereBetween('created_at', [$queryStart, $queryEnd])
            ->orderBy('created_at', 'desc')
            ->get();

        $pelanggans = \App\Models\User::where('role', 'user')
            ->whereBetween('created_at', [$queryStart, $queryEnd])
            ->withCount('pesanan')
            ->orderBy('created_at', 'desc')
            ->get();

        $bahans = PermintaanBahan::with(['pencetakan.buku'])
            ->whereBetween('created_at', [$queryStart, $queryEnd])
            ->orderBy('created_at', 'desc')
            ->get();

        $activeMenu = 'laporan';

        if (view()->exists('admin.pengiriman.laporan')) {
            return view('admin.pengiriman.laporan', compact(
                'pesanans', 'bukus', 'pencetakans', 'bahans', 'pelanggans',
                'range', 'startDate', 'endDate', 'activeMenu'
            ));
        }

        return view('admin.pengiriman.dashboard', [
            'totalSiapDikirim' => Pesanan::whereIn('status', ['Siap Dikirim', 'Siap dikirim'])->count(),
            'totalDikirim' => Pesanan::whereIn('status', ['Dikirim', 'Sedang Dikirim'])->count(),
            'daftarPengiriman' => Pesanan::with('user')->take(5)->get(),
            'pesananTerbaru' => Pesanan::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
            'activeMenu' => $activeMenu
        ]);
    }

    // =====================================================
    // ADMIN LITERASI DIGITAL
    // =====================================================

    public function dashboardLiterasiDigital()
    {
        $totalPencetakan = Pencetakan::where('jenis_literasi', 'Literasi Digital')->count();
        $totalPermintaanBahan = PermintaanBahan::whereHas('pencetakan', function ($q) {
            $q->where('jenis_literasi', 'Literasi Digital');
        })->orWhere('divisi', 'ilike', '%Literasi Digital%')->count();

        $daftarPencetakan = Pencetakan::with(['pesanan.user', 'buku'])
            ->where('jenis_literasi', 'Literasi Digital')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $semuaPencetakan = Pencetakan::with(['pesanan.user', 'buku'])
            ->where('jenis_literasi', 'Literasi Digital')
            ->orderBy('created_at', 'desc')
            ->get();

        $activeMenu = 'dashboard';

        return view('admin.digital.dashboard', compact(
            'totalPencetakan',
            'totalPermintaanBahan',
            'daftarPencetakan',
            'semuaPencetakan',
            'activeMenu'
        ));
    }

    public function semuaPencetakanDigital(Request $request)
    {
        $search = $request->input('search');

        $query = Pencetakan::with(['pesanan.user', 'buku'])
            ->where('jenis_literasi', 'Literasi Digital');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_cetak', 'ilike', "%{$search}%")
                    ->orWhere('pic', 'ilike', "%{$search}%")
                    ->orWhereHas('buku', function ($sub) use ($search) {
                        $sub->where('judul', 'ilike', "%{$search}%");
                    });
            });
        }

        $daftarPencetakan = $query->orderBy('created_at', 'desc')->get();
        $activeMenu = 'pencetakan';

        return view('admin.digital.semua-pencetakan', compact('daftarPencetakan', 'search', 'activeMenu'));
    }

    public function updateProgressDigital(Request $request, $id)
    {
        try {
            $pencetakan = Pencetakan::where('jenis_literasi', 'Literasi Digital')->findOrFail($id);

            if ($request->has('buku_selesai')) {
                $request->validate([
                    'buku_selesai' => 'required|integer|min:0|max:' . ($pencetakan->target_buku ?? 999),
                ]);

                $pencetakan->buku_selesai = $request->buku_selesai;

                if ($pencetakan->target_buku && $pencetakan->buku_selesai >= $pencetakan->target_buku) {
                    $pencetakan->status = 'Selesai';
                } elseif ($pencetakan->buku_selesai > 0 && strtolower($pencetakan->status) == 'menunggu diproses') {
                    $pencetakan->status = 'Diproses';
                }
            }

            if ($request->has('status')) {
                $request->validate(['status' => 'required|string']);
                $pencetakan->status = $request->status;
            }

            $pencetakan->save();

            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => true, 'message' => 'Data pencetakan berhasil diperbarui.']);
            }

            return redirect()->back()->with('success', 'Progress pencetakan berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error Update Pencetakan Digital: ' . $e->getMessage());

            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem atau input tidak valid.'], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function profileDigital()
    {
        $user = auth()->user();
        $activeMenu = 'profile';

        return view('admin.digital.profile', compact('user', 'activeMenu'));
    }

    public function daftarPic()
    {
        $daftarPic = Pic::whereHas('pencetakan', function ($q) {
            $q->where('jenis_literasi', 'Literasi Digital');
        })
        ->orDoesntHave('pencetakan')
        ->orderBy('nama', 'asc')
        ->get();

        foreach ($daftarPic as $pic) {
            $pic->pekerjaan_aktif = Pencetakan::where(function ($q) use ($pic) {
                    $q->where('pic', $pic->nama)->whereNull('alihkan_kepada');
                })
                ->orWhere(function ($q) use ($pic) {
                    $q->where('alihkan_kepada', $pic->nama);
                })
                ->where('jenis_literasi', 'Literasi Digital')
                ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                ->count();
        }

        $activeMenu = 'pic';

        return view('admin.digital.pic', compact('daftarPic', 'activeMenu'));
    }

    public function detailPic($id)
    {
        $pic = Pic::findOrFail($id);

        $data = [
            'nama' => $pic->nama,
            'jabatan' => 'Staf Literasi Digital',
            'nomor_telepon' => $pic->nomor_telepon,
            'keterangan' => $pic->keterangan ?? '-',
            'status' => 'Aktif'
        ];

        $daftarKerjaan = Pencetakan::with('buku')
            ->where('jenis_literasi', 'Literasi Digital')
            ->where(function ($q) use ($pic) {
                $q->where('pic', $pic->nama)->orWhere('alihkan_kepada', $pic->nama);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $semuaPic = Pic::where('id', '!=', $id)
            ->whereHas('pencetakan', function ($q) {
                $q->where('jenis_literasi', 'Literasi Digital');
            })
            ->orDoesntHave('pencetakan')
            ->orderBy('nama')
            ->get();

        $activeMenu = 'pic';

        return view('admin.digital.detail-pic', compact('data', 'daftarKerjaan', 'semuaPic', 'activeMenu'));
    }

    public function alihkanPic(Request $request)
    {
        $request->validate([
            'pencetakan_ids' => 'required|string',
            'pic_tujuan' => 'required|string',
            'alasan_pengalihan' => 'required|string',
        ]);

        $ids = explode(',', $request->pencetakan_ids);

        Pencetakan::whereIn('id', $ids)->update([
            'alihkan_kepada' => $request->pic_tujuan,
            'alasan_pengalihan' => $request->alasan_pengalihan,
        ]);

        return redirect()->back()->with('success', 'Pekerjaan berhasil dialihkan ke ' . $request->pic_tujuan);
    }

    public function storePic(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
        ]);

        Pic::create([
            'nama' => $request->nama,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return redirect()->back()->with('success', 'PIC baru berhasil ditambahkan!');
    }

    // =====================================================
    // PERMINTAAN BAHAN DIGITAL
    // =====================================================

    public function permintaanBahanDigital(Request $request)
    {
        $statusFilter = $request->input('status', 'semua');
        $search = $request->input('search');
        $dateFilter = $request->input('date');

        $query = PermintaanBahan::with(['pencetakan.buku'])
            ->whereHas('pencetakan', function ($q) {
                $q->where('jenis_literasi', 'Literasi Digital');
            })
            ->orWhere('divisi', 'ilike', '%Literasi Digital%')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id_permintaan', 'ilike', "%{$search}%")
                    ->orWhere('nama_bahan', 'ilike', "%{$search}%")
                    ->orWhere('pic', 'ilike', "%{$search}%")
                    ->orWhere('bahan', 'ilike', "%{$search}%");
            });
        }

        if ($dateFilter) {
            $query->whereDate('created_at', $dateFilter);
        }

        if ($statusFilter !== 'semua') {
            $query->where('status', 'ilike', "%{$statusFilter}%");
        }

        $permintaanBahan = $query->get();
        $activeMenu = 'permintaan-bahan';

        return view('admin.digital.permintaan-bahan', compact(
            'permintaanBahan',
            'statusFilter',
            'search',
            'dateFilter',
            'activeMenu'
        ));
    }

    public function detailPermintaanBahanDigital($id)
    {
        $permintaanBahan = PermintaanBahan::with(['pencetakan.buku'])
            ->where(function ($q) {
                $q->whereHas('pencetakan', function ($sub) {
                    $sub->where('jenis_literasi', 'Literasi Digital');
                })
                ->orWhere('divisi', 'ilike', '%Literasi Digital%');
            })
            ->findOrFail($id);

        $activeMenu = 'permintaan-bahan';

        return view('admin.digital.detail-permintaan-bahan', compact('permintaanBahan', 'activeMenu'));
    }

    public function updateStatusBahanDigital(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required|string',
            'kendala' => 'nullable|string'
        ]);

        $bahan = PermintaanBahan::where('id', $request->id)
            ->where(function ($q) {
                $q->whereHas('pencetakan', function ($sub) {
                    $sub->where('jenis_literasi', 'Literasi Digital');
                })
                ->orWhere('divisi', 'Literasi Digital');
            })
            ->firstOrFail();

        if ($request->has('kendala') && !empty($request->kendala)) {
            $bahan->status = 'Kendala';
            $bahan->catatan_kendala = $request->kendala;
        } else {
            $bahan->status = $request->status;
        }

        $bahan->save();

        return redirect()->back()->with('success', 'Status permintaan bahan berhasil diperbarui!');
    }

    public function ajukanPermintaanBahanDigital()
    {
        $daftarPencetakan = Pencetakan::with('buku')
            ->where('jenis_literasi', 'Literasi Digital')
            ->orderBy('created_at', 'desc')
            ->get();

        $activeMenu = 'permintaan-bahan';

        return view('admin.digital.ajukan-permintaan-bahan', compact('daftarPencetakan', 'activeMenu'));
    }

    public function storePermintaanBahanDigital(Request $request)
    {
        $request->validate([
            'pencetakan_id' => 'required',
            'nama_bahan'    => 'required|string|max:255',
            'jumlah'        => 'required|numeric|min:1',
            'satuan'        => 'required|string|max:50',
            'keperluan'     => 'required|string|max:500',
            'surat_dokumen' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $file = $request->file('surat_dokumen');
        $fileName = 'surat_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('surat_pengajuan', $fileName, 'public');

        $permintaan = new PermintaanBahan();
        $permintaan->pencetakan_id = $request->pencetakan_id;
        $permintaan->nama_bahan    = $request->nama_bahan;
        $permintaan->jumlah        = $request->jumlah;
        $permintaan->satuan        = $request->satuan;
        $permintaan->keperluan     = $request->keperluan;
        $permintaan->status        = 'Menunggu Pemeriksaan';
        $permintaan->divisi        = 'Literasi Digital';

        if (Schema::hasColumn('permintaan_bahans', 'file_surat')) {
            $permintaan->file_surat = $path;
        } elseif (Schema::hasColumn('permintaan_bahans', 'dokumen_surat')) {
            $permintaan->dokumen_surat = $path;
        } elseif (Schema::hasColumn('permintaan_bahans', 'surat_path')) {
            $permintaan->surat_path = $path;
        }

        if (Schema::hasColumn('permintaan_bahans', 'id_permintaan')) {
            $permintaan->id_permintaan = 'BHN-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        $permintaan->save();

        return redirect()
            ->route('admin.digital.permintaan-bahan')
            ->with('success', 'Permintaan bahan berhasil diajukan.');
    }

    public function uploadRevisiBahanDigital(Request $request, $id)
    {
        $request->validate([
            'surat_revisi' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $bahan = PermintaanBahan::findOrFail($id);
        $bahan->status = 'Menunggu Pemeriksaan';

        if (Schema::hasColumn('permintaan_bahans', 'catatan_kendala')) {
            $bahan->catatan_kendala = null;
        }
        if (Schema::hasColumn('permintaan_bahans', 'alasan_kendala')) {
            $bahan->alasan_kendala = null;
        }

        $bahan->save();

        return redirect()
            ->route('admin.digital.permintaan-bahan.detail', $bahan->id)
            ->with('success', 'Surat revisi berhasil dikirim. Status kembali ke Menunggu Pemeriksaan');
    }

    // =====================================================
    // ADMIN LITERASI MANUAL
    // =====================================================

    public function dashboardLiterasiManual()
    {
        $totalPencetakan = Pencetakan::where('jenis_literasi', 'Literasi Manual')->count();
        $totalPermintaanBahan = PermintaanBahan::whereHas('pencetakan', function ($q) {
            $q->where('jenis_literasi', 'Literasi Manual');
        })->orWhere('divisi', 'ilike', '%Literasi Manual%')->count();

        $daftarPencetakan = Pencetakan::with(['pesanan.user', 'buku'])
            ->where('jenis_literasi', 'Literasi Manual')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $semuaPencetakan = Pencetakan::with(['pesanan.user', 'buku'])
            ->where('jenis_literasi', 'Literasi Manual')
            ->orderBy('created_at', 'desc')
            ->get();

        $activeMenu = 'dashboard';

        return view('admin.manual.dashboard', compact(
            'totalPencetakan',
            'totalPermintaanBahan',
            'daftarPencetakan',
            'semuaPencetakan',
            'activeMenu'
        ));
    }

    public function semuaPencetakanManual(Request $request)
    {
        $search = $request->input('search');

        $query = Pencetakan::with(['pesanan.user', 'buku'])
            ->where('jenis_literasi', 'Literasi Manual');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_cetak', 'ilike', "%{$search}%")
                    ->orWhere('pic', 'ilike', "%{$search}%")
                    ->orWhereHas('buku', function ($sub) use ($search) {
                        $sub->where('judul', 'ilike', "%{$search}%");
                    });
            });
        }

        $daftarPencetakan = $query->orderBy('created_at', 'desc')->get();
        $activeMenu = 'pencetakan';

        return view('admin.manual.semua-pencetakan', compact('daftarPencetakan', 'search', 'activeMenu'));
    }

    public function updateProgressManual(Request $request, $id)
    {
        try {
            $pencetakan = Pencetakan::where('jenis_literasi', 'Literasi Manual')->findOrFail($id);

            if ($request->has('buku_selesai')) {
                $request->validate([
                    'buku_selesai' => 'required|integer|min:0|max:' . ($pencetakan->target_buku ?? 999),
                ]);

                $pencetakan->buku_selesai = $request->buku_selesai;

                if ($pencetakan->target_buku && $pencetakan->buku_selesai >= $pencetakan->target_buku) {
                    $pencetakan->status = 'Selesai';
                } elseif ($pencetakan->buku_selesai > 0 && strtolower($pencetakan->status) == 'menunggu diproses') {
                    $pencetakan->status = 'Diproses';
                }
            }

            if ($request->has('status')) {
                $request->validate(['status' => 'required|string']);
                $pencetakan->status = $request->status;
            }

            $pencetakan->save();

            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => true, 'message' => 'Data pencetakan berhasil diperbarui.']);
            }

            return redirect()->back()->with('success', 'Progress pencetakan berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error Update Pencetakan Manual: ' . $e->getMessage());

            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem atau input tidak valid.'], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function profileManual()
    {
        $user = auth()->user();
        $activeMenu = 'profile';

        return view('admin.manual.profile', compact('user', 'activeMenu'));
    }

    public function daftarPicManual()
    {
        $daftarPic = Pic::whereHas('pencetakan', function ($q) {
            $q->where('jenis_literasi', 'Literasi Manual');
        })
        ->orDoesntHave('pencetakan')
        ->orderBy('nama', 'asc')
        ->get();

        foreach ($daftarPic as $pic) {
            $pic->pekerjaan_aktif = Pencetakan::where(function ($q) use ($pic) {
                    $q->where('pic', $pic->nama)->whereNull('alihkan_kepada');
                })
                ->orWhere(function ($q) use ($pic) {
                    $q->where('alihkan_kepada', $pic->nama);
                })
                ->where('jenis_literasi', 'Literasi Manual')
                ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                ->count();
        }

        $activeMenu = 'pic';

        return view('admin.manual.pic', compact('daftarPic', 'activeMenu'));
    }

    public function detailPicManual($id)
    {
        $pic = Pic::findOrFail($id);

        $data = [
            'nama' => $pic->nama,
            'jabatan' => 'Staf Literasi Manual',
            'nomor_telepon' => $pic->nomor_telepon,
            'keterangan' => $pic->keterangan ?? '-',
            'status' => 'Aktif'
        ];

        $daftarKerjaan = Pencetakan::with('buku')
            ->where('jenis_literasi', 'Literasi Manual')
            ->where(function ($q) use ($pic) {
                $q->where('pic', $pic->nama)->orWhere('alihkan_kepada', $pic->nama);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $semuaPic = Pic::where('id', '!=', $id)
            ->whereHas('pencetakan', function ($q) {
                $q->where('jenis_literasi', 'Literasi Manual');
            })
            ->orDoesntHave('pencetakan')
            ->orderBy('nama')
            ->get();

        $activeMenu = 'pic';

        return view('admin.manual.detail-pic', compact('data', 'daftarKerjaan', 'semuaPic', 'activeMenu'));
    }

    public function alihkanPicManual(Request $request)
    {
        $request->validate([
            'pencetakan_ids' => 'required|string',
            'pic_tujuan' => 'required|string',
            'alasan_pengalihan' => 'required|string',
        ]);

        $ids = explode(',', $request->pencetakan_ids);

        Pencetakan::whereIn('id', $ids)->update([
            'alihkan_kepada' => $request->pic_tujuan,
            'alasan_pengalihan' => $request->alasan_pengalihan,
        ]);

        return redirect()->back()->with('success', 'Pekerjaan berhasil dialihkan ke ' . $request->pic_tujuan);
    }

    public function storePicManual(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
        ]);

        Pic::create([
            'nama' => $request->nama,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return redirect()->back()->with('success', 'PIC baru berhasil ditambahkan!');
    }

    public function permintaanBahanManual(Request $request)
    {
        $statusFilter = $request->input('status', 'semua');
        $search = $request->input('search');
        $dateFilter = $request->input('date');

        $query = PermintaanBahan::with(['pencetakan.buku'])
            ->where(function ($q) {
                $q->whereHas('pencetakan', function ($sub) {
                    $sub->where('jenis_literasi', 'Literasi Manual');
                })
                ->orWhere('divisi', 'ilike', '%Literasi Manual%')
                ->orWhereNull('pencetakan_id');
            })
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id_permintaan', 'ilike', "%{$search}%")
                    ->orWhere('nama_bahan', 'ilike', "%{$search}%")
                    ->orWhere('pic', 'ilike', "%{$search}%")
                    ->orWhere('bahan', 'ilike', "%{$search}%");
            });
        }

        if ($dateFilter) {
            $query->whereDate('created_at', $dateFilter);
        }

        if ($statusFilter !== 'semua') {
            $query->where('status', 'ilike', "%{$statusFilter}%");
        }

        $permintaanBahan = $query->get();
        $activeMenu = 'permintaan-bahan';

        return view('admin.manual.permintaan-bahan', compact(
            'permintaanBahan',
            'statusFilter',
            'search',
            'dateFilter',
            'activeMenu'
        ));
    }

    public function detailPermintaanBahanManual($id)
    {
        $permintaanBahan = PermintaanBahan::with(['pencetakan.buku'])
            ->where(function ($q) {
                $q->whereHas('pencetakan', function ($sub) {
                    $sub->where('jenis_literasi', 'Literasi Manual');
                })
                ->orWhere('divisi', 'ilike', '%Literasi Manual%')
                ->orWhereNull('pencetakan_id');
            })
            ->findOrFail($id);

        $activeMenu = 'permintaan-bahan';

        return view('admin.manual.detail-permintaan-bahan', compact('permintaanBahan', 'activeMenu'));
    }

    public function updateStatusBahanManual(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required|string',
            'kendala' => 'nullable|string'
        ]);

        $bahan = PermintaanBahan::where('id', $request->id)
            ->where(function ($q) {
                $q->whereHas('pencetakan', function ($sub) {
                    $sub->where('jenis_literasi', 'Literasi Manual');
                })
                ->orWhere('divisi', 'Literasi Manual')
                ->orWhereNull('pencetakan_id');
            })
            ->firstOrFail();

        if ($request->has('kendala') && !empty($request->kendala)) {
            $bahan->status = 'Kendala';
            $bahan->catatan_kendala = $request->kendala;
        } else {
            $bahan->status = $request->status;
        }

        $bahan->save();

        return redirect()->back()->with('success', 'Status permintaan bahan berhasil diperbarui!');
    }

    public function ajukanPermintaanBahanManual()
{
    $daftarPencetakan = Pencetakan::with('buku')
        ->where('jenis_literasi', 'Literasi Manual')
        ->orderBy('created_at', 'desc')
        ->get();

    $activeMenu = 'permintaan-bahan';

    return view('admin.manual.ajukan-permintaan-bahan', compact('daftarPencetakan', 'activeMenu'));
}

public function storePermintaanBahanManual(Request $request)
{
    $request->validate([
        'pencetakan_id' => 'required',
        'nama_bahan'    => 'required|string|max:255',
        'jumlah'        => 'required|numeric|min:1',
        'satuan'        => 'required|string|max:50',
        'keperluan'     => 'required|string|max:500',
        'surat_dokumen' => 'required|file|mimes:pdf,doc,docx|max:5120',
    ]);

    $file = $request->file('surat_dokumen');
    $fileName = 'surat_' . time() . '.' . $file->getClientOriginalExtension();
    $path = $file->storeAs('surat_pengajuan', $fileName, 'public');

    $permintaan = new PermintaanBahan();
    $permintaan->pencetakan_id = $request->pencetakan_id;
    $permintaan->nama_bahan    = $request->nama_bahan;
    $permintaan->jumlah        = $request->jumlah;
    $permintaan->satuan        = $request->satuan;
    $permintaan->keperluan     = $request->keperluan;
    $permintaan->status        = 'Menunggu Pemeriksaan';
    $permintaan->divisi        = 'Literasi Manual';

    if (Schema::hasColumn('permintaan_bahans', 'file_surat')) {
        $permintaan->file_surat = $path;
    } elseif (Schema::hasColumn('permintaan_bahans', 'dokumen_surat')) {
        $permintaan->dokumen_surat = $path;
    }

    if (Schema::hasColumn('permintaan_bahans', 'id_permintaan')) {
        $permintaan->id_permintaan = 'BHN-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    $permintaan->save();

    return redirect()
        ->route('admin.manual.permintaan-bahan')
        ->with('success', 'Permintaan bahan berhasil diajukan.');
}

public function uploadRevisiBahanManual(Request $request, $id)
{
    $request->validate([
        'surat_revisi' => 'required|file|mimes:pdf,doc,docx|max:5120',
    ]);

    $bahan = PermintaanBahan::findOrFail($id);
    $bahan->status = 'Menunggu Pemeriksaan';

    if (Schema::hasColumn('permintaan_bahans', 'catatan_kendala')) {
        $bahan->catatan_kendala = null;
    }
    if (Schema::hasColumn('permintaan_bahans', 'alasan_kendala')) {
        $bahan->alasan_kendala = null;
    }

    $bahan->save();

    return redirect()
        ->route('admin.manual.permintaan-bahan.detail', $bahan->id)
        ->with('success', 'Surat revisi berhasil dikirim. Status kembali ke Menunggu Pemeriksaan');
}
}