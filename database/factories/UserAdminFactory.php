<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'password' => 'admin',
            'username_admin' => 'admin'
        ];
    }
}
