<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payout>
 */
class PayoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 2,
            'ammount' => $this->faker->numberBetween(1, 1000),
            'dataUsed' => $this->faker->numberBetween(1, 10000),
            'seconds' => $this->faker->numberBetween(1, 100),
            'wallet' => $this->faker->numberBetween(1, 100),
        ];
    }
}
