<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Materi;
use App\Models\Student;
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
        // Program::factory(20)->create();
        // Materi::factory(10)->create();
        UserAdmin::factory(1)->create();

        // UserAdmin::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        // ]);
        
    }
}
