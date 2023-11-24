<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParametersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert default parameters
        $parameters = [
            [
                'key' => 'is_registration_open',
                'type' => 'boolean',
                'value' => 'true',
            ],
            [
                'key' => 'are_santa_ready',
                'type' => 'boolean',
                'value' => 'false',
            ],
            [
                'key' => 'is_santa_panel_accessible',
                'type' => 'boolean',
                'value' => 'false',
            ]
        ];

        foreach ($parameters as $parameter) {
            \App\Models\Parameter::insertOrIgnore($parameter);
        }
    }
}
