<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Administrator;
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

        Administrator::create([
            'administrator_name' => 'admin',
            'username' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('admin')
        ]);
        Teacher::create([
            'teacher_name' => 'Fakhri Sabil',
            'username' => 'fakhri',
            'password' => \Illuminate\Support\Facades\Hash::make('fakhri')
        ]);

        // Program::factory(5)->create();
        // Materi::factory(15)->create();
        // Teacher::factory(10)->create();

        // Sekolah::factory(5)->create();

       

        // Student::create([
        //     'nama_siswa' => fake()->name(),
        //     'status'=> 'diterima',
        //     'ktp' => '3525151906990004',
        //     'email' => fake()->freeEmail(),
        //     'tanggal_lahir' => fake()->date(),
        //     'password'=> fake()->randomNumber(7, true),
        //     'nomor_pendaftaran' => fake()->randomNumber(7, true),
        //     'tahun_daftar' => '2022'
        // ]);

        // Student::create([
        //     'nama_siswa' => fake()->name(),
        //     'status'=> 'diterima',
        //     'ktp' => '3525151906990005',
        //     'email' => fake()->freeEmail(),
        //     'tanggal_lahir' => fake()->date(),
        //     'password'=> fake()->randomNumber(7, true),
        //     'nomor_pendaftaran' => fake()->randomNumber(7, true),
        //     'tahun_daftar' => '2022'
        // ]);

        // Student::create([
        //     'nama_siswa' => fake()->name(),
        //     'status'=> 'diterima',
        //     'ktp' => '3525151906990006',
        //     'email' => fake()->freeEmail(),
        //     'tanggal_lahir' => fake()->date(),
        //     'password'=> fake()->randomNumber(7, true),
        //     'nomor_pendaftaran' => fake()->randomNumber(7, true),
        //     'tahun_daftar' => '2022'
        // ]);
        
    }
}
