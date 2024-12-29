<?php

namespace Database\Factories;
use App\Models\asset;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\asset>
 */
class AssetFactory extends Factory
{
    protected $model = asset::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['domain name', 'ip address']);
        if($type == 'domain name') {
            $name = fake()->domainName;
        }else{
            $name = fake()->ipv4;
        }
        return [
            //
            'user_id' => 1,
            'status' => 'approved',
            'type' => $type,
            'name' => $name,
        ];
    }
}
