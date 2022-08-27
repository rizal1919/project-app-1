<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kurikulum;
use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Materi;
use App\Models\Sekolah;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UserAdmin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Program::factory(5)->create();
        Materi::factory(15)->create();
        UserAdmin::factory(1)->create();
        Kurikulum::factory(2)->create();
        Teacher::factory(10)->create();

        Sekolah::factory(5)->create();

        Student::create([
            'nama_siswa' => fake()->name(),
            'status'=> 'diterima',
            'ktp' => '3525151906990001',
            'email' => fake()->freeEmail(),
            'tanggal_lahir' => fake()->date(),
            'password'=> fake()->randomNumber(7, true),
            'nomor_pendaftaran' => fake()->randomNumber(7, true),
            'tahun_daftar' => '2022'
        ]);

        Student::create([
            'nama_siswa' => fake()->name(),
            'status'=> 'diterima',
            'ktp' => '3525151906990002',
            'email' => fake()->freeEmail(),
            'tanggal_lahir' => fake()->date(),
            'password'=> fake()->randomNumber(7, true),
            'nomor_pendaftaran' => fake()->randomNumber(7, true),
            'tahun_daftar' => '2022'
        ]);

        Student::create([
            'nama_siswa' => fake()->name(),
            'status'=> 'diterima',
            'ktp' => '3525151906990003',
            'email' => fake()->freeEmail(),
            'tanggal_lahir' => fake()->date(),
            'password'=> fake()->randomNumber(7, true),
            'nomor_pendaftaran' => fake()->randomNumber(7, true),
            'tahun_daftar' => '2022'
        ]);
        
    }
}
