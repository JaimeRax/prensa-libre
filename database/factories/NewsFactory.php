<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'title'        => $this->faker->sentence(6),
            'image_url'    => 'https://picsum.photos/seed/'.$this->faker->unique()->lexify('????????').'/800/450',
            'excerpt'      => $this->faker->paragraph(),
            'body'         => $this->faker->paragraphs(4, true),
            'published_at' => now()->subDays(rand(0, 5)),
            'user_id'      => null,
        ];
    }
}
