<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Resi - BrailleKita</title>
    <style>
        @page { size: A4 landscape; margin: 10mm; }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #000; background: #eee; }

        .print-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .resi-box {
            border: 1px solid #000;
            padding: 14px;
            background: white;
            position: relative;
            break-inside: avoid;
        }

        .resi-number {
            position: absolute;
            top: 4px; left: 6px;
            font-size: 11px; font-weight: bold;
        }

        .kop-surat { display: flex; align-items: center; gap: 10px; margin-bottom: 6px; padding-left: 20px; }
        .kop-logo { width: 44px; height: 44px; flex-shrink: 0; }
        .kop-logo img { width: 100%; height: 100%; object-fit: contain; }
        .kop-text { flex-grow: 1; text-align: center; }
        .kop-text h1 { font-size: 12px; font-weight: bold; line-height: 1.3; }
        .kop-text h2 { font-size: 12px; font-weight: bold; line-height: 1.3; }
        .kop-text h3 { font-size: 13px; font-weight: bold; line-height: 1.3; }
        .kop-text p { font-size: 9px; line-height: 1.3; }

        .kop-line { border-bottom: 2px solid #000; margin-bottom: 10px; }

        .tanggal-surat { text-align: right; font-size: 11px; margin-bottom: 8px; }

        .isi-pembuka { font-size: 11px; margin-bottom: 8px; line-height: 1.5; }

        .kepada-block { font-size: 11px; margin-bottom: 10px; line-height: 1.6; }
        .kepada-block .label { display: inline-block; width: 110px; }
        .kepada-block .value { font-weight: bold; }

        table.resi-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        table.resi-table th, table.resi-table td {
            border: 1px solid #000; padding: 3px 6px; font-size: 10px; text-align: left;
        }
        table.resi-table th { text-align: center; font-weight: bold; }
        table.resi-table td.col-no { text-align: center; width: 26px; }
        table.resi-table td.col-banyak { text-align: center; width: 55px; }
        table.resi-table td.col-ket { text-align: center; width: 55px; }

        .diterima-tgl { font-size: 11px; margin-bottom: 16px; }

        .ttd-row { display: flex; justify-content: space-between; margin-bottom: 16px; }
        .ttd-col { text-align: center; width: 45%; }
        .ttd-col .ttd-label { font-size: 11px; font-weight: bold; margin-bottom: 40px; }
        .ttd-col .ttd-sub { font-size: 10px; }
        .ttd-col .ttd-name { font-size: 11px; font-weight: bold; margin-top: 4px; }
        .ttd-titik { font-size: 11px; }

        .catatan-kaki { font-size: 9px; font-style: italic; line-height: 1.4; }

        @media print {
            body { background: white; }
            .no-print { display: none; }
            .resi-box { page-break-inside: avoid; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="padding: 12px; text-align: center;">
        <button onclick="window.print()" style="padding: 8px 20px; font-weight: bold; cursor: pointer;">Cetak / Save PDF</button>
    </div>

    <div class="print-container">
        @foreach($daftarPesanan as $index => $pesanan)
            <div class="resi-box">
                <div class="resi-number">{{ $index + 1 }}.</div>

                <div class="kop-surat">
                    <div class="kop-logo">
                        <img src="{{ asset('images/logo-kemensos.png') }}" alt="Logo" onerror="this.style.display='none'">
                    </div>
                    <div class="kop-text">
                        <h1>KEMENTERIAN SOSIAL REPUBLIK INDONESIA</h1>
                        <h2>DIREKTORAT JENDERAL REHABILITASI SOSIAL</h2>
                        <h3>SENTRA WYATAGUNA BANDUNG</h3>
                        <p>Jl. Pajajaran No. 50-52 Telp/Fax. (022) 4205214 Bandung 40171</p>
                        <p>E-mail : literasibraillewyataguna@gmail.com Website : http://wyataguna.kemsos.go.id</p>
                    </div>
                </div>
                <div class="kop-line"></div>

                <div class="tanggal-surat">Bandung, {{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}</div>

                <div class="isi-pembuka">Bersama ini kami kirimkan Buku-Buku Braille dibawah ini dengan rincian :</div>

                <div class="kepada-block">
                    <div><span class="label">KEPADA :</span> <span class="value">{{ $pesanan->nama_penerima }}</span></div>
                    <div><span class="label">No. Telepon :</span> <span class="value">{{ $pesanan->telepon }}</span></div>
                    <div>
                        <span class="label">ALAMAT PENERIMA :</span>
                        <span class="value">
                            {{ $pesanan->alamat_lengkap }},
                            {{ $pesanan->kecamatan }},
                            {{ $pesanan->kota }},
                            {{ $pesanan->provinsi }}
                            {{ $pesanan->kode_pos }}
                        </span>
                    </div>
                </div>

                <table class="resi-table">
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>JUDUL BUKU</th>
                            <th>BANYAK<br>(eks)</th>
                            <th>KET</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan->details as $i => $detail)
                            <tr>
                                <td class="col-no">{{ $i + 1 }}</td>
                                <td>{{ $detail->buku->judul ?? '-' }}</td>
                                <td class="col-banyak">{{ $detail->jumlah }}</td>
                                <td class="col-ket">SET Ke-1</td>
                            </tr>
                        @endforeach

                        {{-- Baris kosong tambahan supaya tampilan konsisten dengan template asli --}}
                        @for($i = $pesanan->details->count(); $i < 11; $i++)
                            <tr>
                                <td class="col-no">{{ $i + 1 }}</td>
                                <td>&nbsp;</td>
                                <td class="col-banyak">&nbsp;</td>
                                <td class="col-ket">&nbsp;</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>

                <div class="diterima-tgl">DITERIMA TGL. &nbsp; : ..........................</div>

                <div class="ttd-row">
                    <div class="ttd-col">
                        <div class="ttd-label">Yang Menerima</div>
                        <div class="ttd-titik">.............................................</div>
                    </div>
                    <div class="ttd-col">
                        <div class="ttd-sub">Menyetujui,<br>Koordinator Literasi</div>
                        <div class="ttd-name">Tine Gustini</div>
                    </div>
                </div>

                <div class="catatan-kaki">
                    Setelah barang beserta surat pengantar ini diterima, mohon konfirmasi dengan mengirimkan bukti ini
                    melalui Whatsapp atau dengan pesan SMS ke Nomor 081122892022 dengan Mengirimkan Format
                    Foto Surat Pengantar yang sudah di tanda tangani. Untuk kritik dan saran dapat disampaikan ke nomor
                    yang tertera diatas.
                </div>
            </div>
        @endforeach
    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>

</body>
</html>