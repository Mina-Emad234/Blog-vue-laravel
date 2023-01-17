<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->words(2,true);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => fake()->sentence(15),
            'image' => fake()->imageUrl(),
            'user_id'=> User::inRandomOrder()->first()->id,
            'category_id'=> Category::inRandomOrder()->first()->id,
        ];
    }
}
