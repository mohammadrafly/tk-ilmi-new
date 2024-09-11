<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriTransaksi;

class Kategori extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriTransaksi::create([
            'nama' => 'SPP',
            'harga' => '100000',
            'interval' => '30',
        ]);

        KategoriTransaksi::create([
            'nama' => 'Seragam',
            'harga' => '150000',
            'interval' => '365',
        ]);

        KategoriTransaksi::create([
            'nama' => 'Uang Gedung',
            'harga' => '200000',
            'interval' => '365',
        ]);
    }
}
