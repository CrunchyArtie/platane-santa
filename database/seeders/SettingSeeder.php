<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create default settings
        $settings = [
            ['key' => 'is_santa_panel_accessible', 'value' => 'true'],
            ['key' => 'is_registration_open', 'value' => 'false'],
            ['key' => 'is_image_mode_active', 'value' => 'false'],
            ['key' => 'are_santa_ready', 'value' => 'true'],
            ['key' => 'santa_joke_target', 'value' => ''],
            ['key' => 'is_image_and_question', 'value' => 'false'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::create($setting);
        }
    }
}
