<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'nama_siswa' => fake()->name(),
            'paket_pilihan' => mt_rand(1,2),
            'ktp' => fake()->randomNumber(5, true),
            'email' => fake()->freeEmail(),
            'tanggal_lahir' => fake()->date(),
            'password'=> fake()->randomNumber(7, true),
            'nomor_pendaftaran' => fake()->randomNumber(7, true),
            'tahun_daftar' => '2022'

        ];
    }
}
