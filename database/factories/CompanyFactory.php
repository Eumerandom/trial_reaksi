<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'slug' => Str::slug($this->faker->unique()->company()).'-'.$this->faker->unique()->numerify('##'),
            'symbol' => strtoupper($this->faker->unique()->lexify('????')),
            'parent_id' => null,
            'status' => $this->faker->randomElement(['affiliated', 'unaffiliated']),
            'logo' => null,
        ];
    }
}
