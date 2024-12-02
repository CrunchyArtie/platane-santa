<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer le compte admin
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@' . (string) env('SESSION_DOMAIN'),
            'password' => bcrypt('password'),
        ]);

        if(env('APP_ENV') === 'production') {
            echo 'Admin created with email: ' . $admin->email;
        } else {
            echo 'Admin created with email: ' . $admin->email . ' and password: password' . PHP_EOL;
        }
    }
}
