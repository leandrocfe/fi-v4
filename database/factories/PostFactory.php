<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => str($title)->slug(),
            'content' => $this->faker->paragraphs(3, true),
            'image' => $this->faker->word(),
            'tags' => ['laravel', 'livewire', 'filament'],
            'published' => $this->faker->boolean(),
            'published_at' => $this->faker->dateTimeThisMonth(),
            'user_id' => User::factory(),
        ];
    }
}
