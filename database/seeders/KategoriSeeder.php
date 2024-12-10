<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriTransaksi;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriTransaksi::create([
            'nama' => 'Pendaftaran',
            'harga' => '100000',
            'interval' => '999',
        ]);
    }
}
