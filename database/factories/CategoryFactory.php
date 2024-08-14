<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'name' => $title,
            'slug' => str($title)->slug(),
            'content' => $this->faker->paragraphs(3, true),
            'published' => $this->faker->boolean(),
            'published_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
