<?php

namespace Database\Seeders;

use App\Models\Siswa as ModelSiswa;
use Illuminate\Database\Seeder;

class Siswa extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelSiswa::factory(10)->create();
    }
}
