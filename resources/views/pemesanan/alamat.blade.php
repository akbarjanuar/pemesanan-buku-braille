<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alamat Pengiriman - BrailleKita</title>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --background: #f8f8f8;
            --foreground: #111111;
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --muted: #eeeeee;
            --muted-foreground: #5a5a5a;
            --border: #d4d4d4;
            --success: #2e7d32;
        }

        *, ::after, ::before { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: var(--background); color: var(--foreground); font-family: 'Atkinson Hyperlegible', sans-serif; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        .navbar { background: var(--primary); color: white; position: sticky; top: 0; z-index: 100; }
        .navbar-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 12px; min-height: 64px; }
        .nav-logo { background: white; color: var(--primary); font-weight: 700; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-size: 18px; }
        .nav-brand { font-size: 20px; font-weight: 700; }
        .nav-spacer { flex-grow: 1; }
        .nav-link { padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 15px; border: 1px solid transparent; }
        .nav-link.active { background-color: white; color: var(--primary); }
        .nav-link.outline { border-color: rgba(255, 255, 255, 0.4); }

        .main-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px 60px 20px; }
        .page-title { font-size: 26px; font-weight: 700; margin-bottom: 24px; }

        .stepper { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; }
        .step-circle { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0; }
        .step-circle.active { background: var(--primary); color: white; }
        .step-circle.done { background: var(--success); color: white; }
        .step-label { font-weight: 700; font-size: 15px; }
        .step-line { flex-grow: 1; height: 2px; background: var(--border); max-width: 200px; }

        .order-layout { display: grid; grid-template-columns: 1fr 320px; gap: 28px; align-items: start; }

        .form-card { background: white; border: 1px solid var(--border); border-radius: 8px; padding: 28px; }
        .form-card h3 { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .form-card p.desc { color: var(--muted-foreground); font-size: 14px; margin-bottom: 20px; }

        .form-group { margin-bottom: 18px; }
        .form-group label { font-weight: 700; font-size: 15px; margin-bottom: 6px; display: block; }
        .form-group .required { color: var(--primary); }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%; border: 1px solid var(--border); border-radius: 6px;
            padding: 12px 14px; font-size: 15px; font-family: inherit; color: var(--foreground);
            background: white;
        }
        .form-group select:disabled { background: var(--muted); color: var(--muted-foreground); cursor: not-allowed; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--primary); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        .error-text { color: var(--primary); font-size: 13px; margin-top: 4px; }
        .loading-text { color: var(--muted-foreground); font-size: 13px; margin-top: 4px; display: none; }

        .form-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 24px; }
        .btn-back { background: white; color: var(--foreground); border: 1px solid var(--border); padding: 12px 20px; border-radius: 6px; font-weight: 700; font-size: 15px; cursor: pointer; font-family: inherit; }
        .btn-back:hover { background: var(--muted); }
        .btn-next { background: var(--primary); color: white; border: none; padding: 12px 24px; border-radius: 6px; font-weight: 700; font-size: 15px; cursor: pointer; font-family: inherit; }
        .btn-next:hover { background: var(--primary-hover); }

        .summary-card { background: white; border: 1px solid var(--border); border-radius: 8px; padding: 24px; position: sticky; top: 88px; }
        .summary-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; }
        .summary-item { display: flex; justify-content: space-between; font-size: 15px; margin-bottom: 12px; color: var(--muted-foreground); }
        .summary-item strong { color: var(--success); font-weight: 700; }
        .summary-divider { border-bottom: 1px solid var(--border); margin: 16px 0; }
        .summary-total { display: flex; justify-content: space-between; font-size: 15px; margin-bottom: 8px; }
        .summary-total strong { color: var(--success); }
        .summary-note { background: var(--muted); border-radius: 6px; padding: 12px; font-size: 14px; font-weight: 700; margin-top: 8px; }

        @media (max-width: 768px) {
            .order-layout { grid-template-columns: 1fr; }
            .form-row, .form-row-3 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="navbar-container">
            <div class="nav-logo">B</div>
            <a href="/" class="nav-brand">BrailleKita</a>
            <div class="nav-spacer"></div>
            <a href="/" class="nav-link outline">Katalog</a>
            <a href="/pesanan-saya" class="nav-link outline">Pesanan Saya</a>
            <a href="/keranjang" class="nav-link active">Keranjang</a>
        </div>
    </header>

    <main class="main-container">
        <h1 class="page-title">Pemesanan Buku</h1>

        <div class="stepper">
            <div class="step-circle done">✓</div>
            <span class="step-label">Jenis Pemesanan</span>
            <div class="step-line"></div>
            <div class="step-circle active">2</div>
            <span class="step-label">Alamat Pengiriman</span>
        </div>

        <form action="/pemesanan/simpan" method="POST" id="formAlamat">
            @csrf
            <div class="order-layout">
                <div class="form-card">
                    <h3>Alamat Pengiriman</h3>
                    <p class="desc">Isi data penerima untuk pengiriman buku pesanan Anda.</p>

                    <div class="form-group">
                        <label>Nama Penerima <span class="required">*</span></label>
                        <input type="text" name="nama_penerima" value="{{ old('nama_penerima', auth()->user()->nama) }}" placeholder="Nama lengkap penerima" required>
                        @error('nama_penerima') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label>Nomor Telepon <span class="required">*</span></label>
                        <input type="text" name="telepon" value="{{ old('telepon', auth()->user()->nomor_telepon) }}" placeholder="08xxxxxxxxxx" required>
                        @error('telepon') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-row-3">
                        <div class="form-group">
                            <label>Provinsi <span class="required">*</span></label>
                            <select name="provinsi" id="provinsi" required>
                                <option value="">Memuat...</option>
                            </select>
                            @error('provinsi') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Kota/Kabupaten <span class="required">*</span></label>
                            <select name="kota" id="kota" required disabled>
                                <option value="">Pilih provinsi dulu</option>
                            </select>
                            @error('kota') <div class="error-text">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Kecamatan <span class="required">*</span></label>
                            <select name="kecamatan" id="kecamatan" required disabled>
                                <option value="">Pilih kota dulu</option>
                            </select>
                            @error('kecamatan') <div class="error-text">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat Lengkap <span class="required">*</span></label>
                        <textarea name="alamat_lengkap" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW" required>{{ old('alamat_lengkap') }}</textarea>
                        @error('alamat_lengkap') <div class="error-text">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label>Kode Pos</label>
                        <!-- Menambahkan id="kode_pos" agar bisa diisi otomatis oleh JS -->
                        <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" placeholder="jika tidak sesuai, isi manual" readonly>
                    </div>

                    <div class="form-group">
                        <label>Catatan Tambahan</label>
                        <textarea name="catatan" rows="2" placeholder="Opsional, misal patokan lokasi">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="form-actions">
                        <a href="/pemesanan" class="btn-back">&larr; Kembali</a>
                        <button type="submit" class="btn-next">Selesaikan Pesanan</button>
                    </div>
                </div>

                <div class="summary-card">
                    <h3 class="summary-title">Ringkasan Pesanan</h3>
                    @foreach($daftarKeranjang ?? [] as $item)
                        <div class="summary-item">
                            <span>{{ $item->buku->judul }}</span>
                            <strong>Gratis</strong>
                        </div>
                    @endforeach
                    <div class="summary-divider"></div>
                    <div class="summary-total">
                        <span>Total Buku</span>
                        <span>{{ collect($daftarKeranjang ?? [])->sum('jumlah') }} eksemplar</span>
                    </div>
                    <div class="summary-total">
                        <span>Total Biaya</span>
                        <strong>Rp0</strong>
                    </div>
                    <div class="summary-note">Jenis: {{ $jenisPesanan ?? 'Pribadi' }}</div>
                </div>
            </div>
        </form>
    </main>

    <script>
        // Data wilayah Indonesia dari API publik gratis (emsifa)
        const API_BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

        const provinsiSelect = document.getElementById('provinsi');
        const kotaSelect = document.getElementById('kota');
        const kecamatanSelect = document.getElementById('kecamatan');
        const kodePosInput = document.getElementById('kode_pos'); // Definisi input kode pos

        // 1. Ambil daftar provinsi saat halaman dimuat
        fetch(`${API_BASE}/provinces.json`)
            .then(res => res.json())
            .then(data => {
                provinsiSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                data.forEach(prov => {
                    const opt = document.createElement('option');
                    opt.value = prov.name;
                    opt.dataset.id = prov.id;
                    opt.textContent = prov.name;
                    provinsiSelect.appendChild(opt);
                });
            })
            .catch(() => {
                provinsiSelect.innerHTML = '<option value="">Gagal memuat data, isi manual tidak tersedia</option>';
            });

        // 2. Saat provinsi dipilih, ambil daftar kota/kabupaten
        provinsiSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const provinceId = selectedOption.dataset.id;

            kotaSelect.innerHTML = '<option value="">Memuat...</option>';
            kotaSelect.disabled = true;
            kecamatanSelect.innerHTML = '<option value="">Pilih kota dulu</option>';
            kecamatanSelect.disabled = true;
            kodePosInput.value = ''; // Reset kode pos

            if (!provinceId) {
                kotaSelect.innerHTML = '<option value="">Pilih provinsi dulu</option>';
                return;
            }

            fetch(`${API_BASE}/regencies/${provinceId}.json`)
                .then(res => res.json())
                .then(data => {
                    kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                    data.forEach(kota => {
                        const opt = document.createElement('option');
                        opt.value = kota.name;
                        opt.dataset.id = kota.id;
                        opt.textContent = kota.name;
                        kotaSelect.appendChild(opt);
                    });
                    kotaSelect.disabled = false;
                });
        });

        // 3. Saat kota dipilih, ambil daftar kecamatan
        kotaSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const regencyId = selectedOption.dataset.id;

            kecamatanSelect.innerHTML = '<option value="">Memuat...</option>';
            kecamatanSelect.disabled = true;
            kodePosInput.value = ''; // Reset kode pos

            if (!regencyId) {
                kecamatanSelect.innerHTML = '<option value="">Pilih kota dulu</option>';
                return;
            }

            fetch(`${API_BASE}/districts/${regencyId}.json`)
                .then(res => res.json())
                .then(data => {
                    kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(kec => {
                        const opt = document.createElement('option');
                        opt.value = kec.name;
                        opt.textContent = kec.name;
                        kecamatanSelect.appendChild(opt);
                    });
                    kecamatanSelect.disabled = false;
                });
        });

    // 4. Saat kecamatan dipilih, cari kode pos otomatis
        kecamatanSelect.addEventListener('change', function () {
            const kecamatanName = this.value;
            
            if (!kecamatanName) {
                kodePosInput.value = '';
                return;
            }
            
            kodePosInput.value = 'Mencari...';

            // Hit ke API pencarian kode pos berdasarkan kecamatan
            fetch(`https://kodepos.vercel.app/search?q=${encodeURIComponent(kecamatanName)}`)
                .then(res => res.json())
                .then(res => {
                    if (res && res.data && res.data.length > 0) {
                        // Cek field code atau postalcode yang tersedia dari response
                        const item = res.data[0];
                        kodePosInput.value = item.code || item.postalcode || item.postcode || '';
                    } else {
                        kodePosInput.value = '';
                    }
                })
                .catch(() => {
                    // Jika API gagal/offline, biarkan kosong agar pengguna bisa isi manual
                    kodePosInput.value = '';
                });
        });
    </script>
</body>
</html>