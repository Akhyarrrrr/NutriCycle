<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produk = [
            ['nama' => 'Pakan Ayam Organik', 'deskripsi' => 'Pakan bernutrisi dari olahan sampah organik rumah tangga untuk ayam kampung dan petelur.', 'harga' => 35000, 'stok' => 80, 'kategori' => 'Unggas'],
            ['nama' => 'Pelet Ikan Daur Ulang', 'deskripsi' => 'Pelet ekonomis dengan komposisi protein seimbang untuk budidaya ikan air tawar.', 'harga' => 42000, 'stok' => 55, 'kategori' => 'Ikan'],
            ['nama' => 'Pakan Bebek Fermentasi', 'deskripsi' => 'Campuran pakan fermentasi yang membantu menjaga energi dan pertumbuhan bebek.', 'harga' => 38000, 'stok' => 45, 'kategori' => 'Unggas'],
            ['nama' => 'Konsentrat Kambing Hijau', 'deskripsi' => 'Konsentrat tambahan dari bahan organik terseleksi untuk kambing dan domba.', 'harga' => 58000, 'stok' => 35, 'kategori' => 'Ruminansia'],
            ['nama' => 'Starter Maggot Kering', 'deskripsi' => 'Protein kering berbasis maggot untuk campuran pakan unggas, ikan, dan reptil.', 'harga' => 65000, 'stok' => 25, 'kategori' => 'Protein'],
        ];

        foreach ($produk as $item) {
            Produk::updateOrCreate(
                ['slug' => Str::slug($item['nama'])],
                [
                    'nama' => $item['nama'],
                    'deskripsi' => $item['deskripsi'],
                    'gambar' => null,
                    'harga' => $item['harga'],
                    'stok' => $item['stok'],
                    'kategori' => $item['kategori'],
                    'is_active' => true,
                ],
            );
        }
    }
}
