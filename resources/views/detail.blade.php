<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $buku->judul }} - BrailleKita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --background: #f8f8f8;
            --foreground: #111111;
            --card: #ffffff;
            --primary: #c62828;
            --primary-hover: #b71c1c;
            --muted: #eeeeee;
            --muted-foreground: #5a5a5a;
            --border: #d4d4d4;
            --success: #2e7d32;
        }

        *, ::after, ::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--background);
            color: var(--foreground);
            font-family: 'Atkinson Hyperlegible', system-ui, sans-serif;
            font-size: 16px;
            line-height: 1.6;
        }

        a { text-decoration: none; color: inherit; }

        /* Layout Detail */
        .detail-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px 20px 60px 20px;
        }

        .breadcrumb {
            font-size: 15px;
            margin-bottom: 24px;
        }

        .breadcrumb a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .breadcrumb span {
            color: var(--muted-foreground);
        }

        .detail-layout {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 40px;
            align-items: start;
        }

        /* Cover Kiri */
        .cover-large {
            color: white;
            border-radius: 12px;
            height: 500px;
            padding: 32px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: sticky;
            top: 88px;
        }

        .dots-large {
            display: grid;
            grid-template-columns: repeat(2, 12px);
            gap: 8px;
            margin-bottom: auto;
            margin-top: auto;
        }
        
        .dots-large span {
            width: 12px;
            height: 12px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
        }

        .cover-large h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .cover-large p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Konten Kanan */
        .badge-category {
            background: var(--muted);
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 16px;
        }

        .title-large {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .author-text {
            font-size: 18px;
            color: var(--muted-foreground);
            margin-bottom: 24px;
        }

        .desc-text {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        /* Spesifikasi Grid */
        .specs-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px 16px;
            margin-bottom: 24px;
        }

        .spec-item label {
            display: block;
            font-size: 13px;
            color: var(--muted-foreground);
            margin-bottom: 4px;
            font-weight: 700;
        }

        .spec-item span {
            font-size: 16px;
            font-weight: 700;
        }

        /* Promo Box */
        .promo-box {
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            border-radius: 8px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: #1b5e20;
            margin-bottom: 24px;
        }

        /* Action Area */
        .action-area {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 16px;
        }

        .price-label {
            font-size: 13px;
            color: var(--muted-foreground);
            margin-bottom: 4px;
        }

        .price-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--success);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .price-strike {
            font-size: 16px;
            color: #9e9e9e;
            text-decoration: line-through;
            background: var(--muted);
            padding: 2px 6px;
            border-radius: 4px;
        }

        .btn-add-cart {
            background: var(--primary);
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            font-family: inherit;
        }

        .btn-add-cart:hover {
            background: var(--primary-hover);
        }

        .warning-text {
            color: #d84315;
            font-size: 14px;
            font-weight: 700;
        }

        /* Responsive Mobile Update */
        @media (max-width: 768px) {
            .detail-layout {
                grid-template-columns: 1fr;
                gap: 24px;
            }
            .cover-large {
                position: relative;
                top: 0;
                height: 320px;
                padding: 20px;
            }
            .title-large {
                font-size: 24px;
            }
            .specs-card {
                grid-template-columns: 1fr 1fr;
            }
            .action-area {
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
            }
            .action-area form {
                width: 100%;
            }
            .btn-add-cart {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    {{-- Memanggil komponen Navbar dinamis yang ramah disabilitas --}}
    @include('partials.navbar')

    <main class="detail-wrapper">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/">Katalog</a> <span>›</span> {{ $buku->judul }}
        </div>

        <div class="detail-layout">
            <!-- Kolom Kiri: Cover Buku -->
            <div class="cover-large" style="background-color: {{ $buku->warna_cover }};">
                <div class="dots-large">
                    <span></span><span></span><span></span><span></span><span></span><span></span>
                </div>
                <h2>{{ $buku->judul }}</h2>
                <p>{{ $buku->pengarang }}</p>
            </div>

            <!-- Kolom Kanan: Informasi Buku -->
            <div class="detail-content">
                <div class="badge-category">{{ $buku->kategori }}</div>
                <h1 class="title-large">{{ $buku->judul }}</h1>
                <p class="author-text">oleh {{ $buku->pengarang }}</p>

                <p class="desc-text">Buku lengkap dalam huruf Braille Grade 2 dengan format yang mudah diakses dan disesuaikan untuk kenyamanan membaca sentuh yang optimal bagi disabilitas netra.</p>

                <div class="specs-card">
                    <div class="spec-item">
                        <label>ISBN</label>
                        <span>978-602-123-456-7</span>
                    </div>
                    <div class="spec-item">
                        <label>Tahun Terbit</label>
                        <span>2021</span>
                    </div>
                    <div class="spec-item">
                        <label>Penerbit</label>
                        <span>{{ $buku->pengarang }}</span>
                    </div>
                    <div class="spec-item">
                        <label>Jumlah Halaman</label>
                        <span>604 halaman</span>
                    </div>
                    <div class="spec-item">
                        <label>Stok Tersedia</label>
                        <span>{{ $buku->stok }} eksemplar</span>
                    </div>
                    <div class="spec-item">
                        <label>Maks. Pemesanan</label>
                        <span>1 per akun</span>
                    </div>
                </div>

                <div class="promo-box">
                    Buku ini tersedia secara GRATIS — tidak ada biaya apapun.
                </div>

                <div class="action-area">
                    <div>
                        <div class="price-label">Harga per eksemplar</div>
                        <div class="price-value">Gratis <span class="price-strike">Rp0</span></div>
                    </div>
                    
                    <!-- Form Tambah ke Keranjang -->
                    <form action="/keranjang/tambah/{{ $buku->id }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-add-cart">+ Tambah ke Keranjang</button>
                    </form>
                </div>

                <div class="warning-text">
                    Buku ini dibatasi maksimal 1 eksemplar per akun.
                </div>
            </div>
        </div>
    </main>

</body>
</html>