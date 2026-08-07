<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $dataBuku = [
            [
                'judul' => 'Al-Quran dan Terjemahan',
                'pengarang' => 'Kementerian Agama RI',
                'kategori' => 'Agama',
                'stok' => 15,
                'warna_cover' => '#37474f',
            ],
            [
                'judul' => 'Bumi Manusia',
                'pengarang' => 'Pramoedya Ananta Toer',
                'kategori' => 'Fiksi',
                'stok' => 30,
                'warna_cover' => '#4a148c',
            ],
            [
                'judul' => 'Fisika untuk Semua',
                'pengarang' => 'Dr. Siti Rahayu',
                'kategori' => 'Sains',
                'stok' => 60,
                'warna_cover' => '#d84315',
            ],
            [
                'judul' => 'Laskar Pelangi',
                'pengarang' => 'Andrea Hirata',
                'kategori' => 'Fiksi',
                'stok' => 45,
                'warna_cover' => '#1565c0',
            ],
            [
                'judul' => 'Matematika SMA Kelas X',
                'pengarang' => 'Tim Penulis Kemdikbud',
                'kategori' => 'Pendidikan',
                'stok' => 120,
                'warna_cover' => '#1b5e20',
            ],
            [
                'judul' => 'Psikologi Positif',
                'pengarang' => 'Dr. Reza Indragiri Amriel',
                'kategori' => 'Non-Fiksi',
                'stok' => 55,
                'warna_cover' => '#006064',
            ],
            [
                'judul' => 'Sejarah Indonesia Modern',
                'pengarang' => 'Prof. Taufik Abdullah',
                'kategori' => 'Sejarah',
                'stok' => 25,
                'warna_cover' => '#e65100',
            ],
            [
                'judul' => 'Taman Sari: Puisi Pilihan',
                'pengarang' => 'Sapardi Djoko Damono',
                'kategori' => 'Seni & Budaya',
                'stok' => 40,
                'warna_cover' => '#880e4f',
            ],
        ];

        foreach ($dataBuku as $buku) {
            Buku::create($buku);
        }
    }
}