<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'category' => $this->faker->randomElement(['Technology', 'Sports', 'Health', 'Business']),
            'source' => $this->faker->company,
            'url' => $this->faker->url,
            'published_at' => $this->faker->dateTimeThisYear,
        ];
    }
}
