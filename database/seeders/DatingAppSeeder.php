<?php

namespace Database\Seeders;

use App\Models\Interest;
use App\Models\Location;
use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Seeder;

class DatingAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create interests
        $interests = Interest::factory(20)->create();

        // Create users with related data
        User::factory(50)->create()->each(function ($user) use ($interests) {
            // Create preferences
            UserPreference::factory()->create([
                'user_id' => $user->id,
            ]);

            // Create location
            Location::factory()->create([
                'user_id' => $user->id,
            ]);

            // Attach random interests (3-8 per user)
            $user->interests()->attach(
                $interests->random(rand(3, 8))->pluck('id')->toArray()
            );
        });
    }
}
