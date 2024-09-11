<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(Agama::class);
        $this->call(Admin::class);
        $this->call(Siswa::class);
        $this->call(Kategori::class);
    }
}
