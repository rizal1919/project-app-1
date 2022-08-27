<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Materi>
 */
class MateriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama_materi' => fake()->bs(),
            'program_id' => fake()->numberBetween(1,5),
            'jumlah_pertemuan' => fake()->numberBetween(1,3),
            'menit' => rand(30,60)
        ];
    }
}
