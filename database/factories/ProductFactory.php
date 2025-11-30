<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Support\StatusLevel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'status' => $this->faker->randomElement(StatusLevel::values()),
            'company_id' => Company::factory(),
            'categories_id' => Category::factory(),
            'name' => $name,
            'description' => $this->faker->paragraph(),
            'source' => $this->faker->url(),
            'image' => $this->faker->imageUrl(),
            'slug' => Str::slug($name).'-'.$this->faker->unique()->numerify('###'),
            'local_product' => $this->faker->boolean(),
        ];
    }
}
