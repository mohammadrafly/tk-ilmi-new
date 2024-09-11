<?php

namespace Database\Seeders;

use App\Models\Agama as ModelsAgama;
use Illuminate\Database\Seeder;

class Agama extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsAgama::insert([
            [
                'nama' => 'Islam',
            ],
            [
                'nama' => 'Kristen Protestan',
            ],
            [
                'nama' => 'Kristen Katolik',
            ],
            [
                'nama' => 'Hindu',
            ],
            [
                'nama' => 'Buddha',
            ],
            [
                'nama' => 'Konghucu',
            ]
        ]);
    }
}
