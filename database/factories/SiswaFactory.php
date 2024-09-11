<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\Agama;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    protected $model = Siswa::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'alamat' => fake()->address(),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->date(),
            'agama_id' => Agama::inRandomOrder()->first()->id,
            'foto_akte_kelahiran' => null,
            'nama_orang_tua' => fake()->name(),
            'alamat_orang_tua' => fake()->address()
        ];
    }
}
