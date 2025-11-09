<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory {
    public function definition(): array {
        return [
            'title' => $this->faker->streetAddress(),
            'address' => $this->faker->address(),
        ];
    }
}
