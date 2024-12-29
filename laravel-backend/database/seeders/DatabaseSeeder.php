<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Asset;
use App\Models\Halt;
use App\Models\Payout;
use Illuminate\Database\Seeder;
use PragmaRX\Google2FA\Google2FA;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $google2fa = new Google2FA();


        User::factory()->create([
            'username' => 'customer',
            'email' => 'customer@example.com',
            'role' => 'customer',
            'totp' =>  $google2fa->generateSecretKey()
        ]);

        User::factory()->create([
            'username' => 'contributer',
            'email' => 'contributer@example.com',
            'role' => 'contributer',
            'totp' =>  $google2fa->generateSecretKey()
        ]);
    
        Asset::factory(10)->create();
        Halt::factory(60)->create();
        Payout::factory(10)->create();
    
    }
}
