<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAdmin>
 */
class UserAdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        
        return [
            'name_admin' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'username_admin' => 'admin'
        ];
    }
}
