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

        $this->call(AdminSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(QuestionSeeder::class);

        // Si on n'est pas en production, on crée des utilisateurs de test
        if (env('APP_ENV') !== 'production') {
            $this->call(UserSeeder::class);
        }
    }
}
