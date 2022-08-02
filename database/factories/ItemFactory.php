<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomDigit(),
            'quantity' => $this->faker->randomDigit(),
            'description' => $this->faker->text(),
            'category_id' => rand(1,3),
        ];
    }
}
