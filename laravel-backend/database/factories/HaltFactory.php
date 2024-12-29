<?php

namespace Database\Factories;
use Carbon\Carbon;
use App\Models\Asset;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Halt>
 */
class HaltFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $futureTime = Carbon::now()->addMinutes(rand(1, 10))->format('H:i');
        $type = fake()->randomElement(['layer3', 'layer4', 'layer7']);
        if($type == 'layer7') {
            $target = asset::where('user_id', 1)->where('type', 'domain name')->inRandomOrder()->first()->name;
        }else{
            $target = asset::where('user_id', 1)->where('type', 'ip address')->inRandomOrder()->first()->name;
        }
        return [
            'user_id' => 1,
            'name' => $this->faker->word(),
            'method' => fake()->randomElement(['CFB | CloudFlare Bypass', 'NTP | NTP Amplification']),
            'slots' => '0',
            'day' => Carbon::now()->format('Y/m/d'), 
            'hour' => $futureTime,
            'target' => $target,
            'port' => fake()->randomElement([21, 22, 26, 28, 80, 69, 443, 441, 8000, 8080, 3333]),
            'status' => 'upcoming',
            'mode' => fake()->randomElement(['UDP', 'TCP']),
            'type' => $type,
            'duration' => rand(60, 300)
        ];
    }
}
