<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticleTranslation>
 */
class ArticleTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'article_id' => rand(1, 5),
           'title' => fake()->text(),
           'text' => rand(1, 5),
           'language_code' => Arr::random(['en', 'ar', 'ja']),
        ];
    }
}
