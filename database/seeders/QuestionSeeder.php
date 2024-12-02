<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            ['question' => 'Si tu étais un ustensile de cuisine, lequel serais-tu ?'],
            ['question' => 'Si ton nom de super héros commençait par "Captain", tu serais Captain... ?'],
            ['question' => 'Si tu étais un thème de colonie de vacances, ce serait ?'],
            ['question' => 'Si tu étais un meuble dans un vide-grenier, tu serais lequel ?']
        ];

        foreach ($questions as $question) {
            \App\Models\Question::create($question);
        }
    }
}
