<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer le compte admin
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@' . (string) env('SESSION_DOMAIN'),
            'password' => bcrypt('password'),
        ]);

        // Affiche dans la console que le compte admin avec email et mot de passe a été créé
        echo 'Admin created with email: ' . $admin->email . ' and password: password' . PHP_EOL;

         \App\Models\User::factory(4)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
