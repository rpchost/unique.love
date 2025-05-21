<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_matches_for_user()
    {
        // Create test users
        $user = User::factory()->create();
        $potentialMatch1 = User::factory()->create();
        $potentialMatch2 = User::factory()->create();

        // Create matches with different compatibility scores
        UserMatch::create([
            'user_id' => $user->id,
            'potential_match_id' => $potentialMatch1->id,
            'compatibility_score' => 85,
            'processed_at' => now(),
        ]);

        UserMatch::create([
            'user_id' => $user->id,
            'potential_match_id' => $potentialMatch2->id,
            'compatibility_score' => 90,
            'processed_at' => now(),
        ]);

        // Make request to the controller
        $response = $this->get("/matches?user_id={$user->id}");

        // Assert response is successful
        $response->assertStatus(200);

        // Assert view has correct data
        $response->assertViewHas('user', $user);
        $response->assertViewHas('matches');

        // Assert matches are ordered by compatibility score (desc)
        $matches = $response->viewData('matches');
        $this->assertEquals(2, $matches->count());
        $this->assertEquals($potentialMatch2->id, $matches->first()->potentialMatch->id);
        $this->assertEquals(90, $matches->first()->compatibility_score);
    }

    public function test_index_returns_empty_matches_when_none_exist()
    {
        // Create a user with no matches
        $user = User::factory()->create();

        // Make request to the controller
        $response = $this->get("/matches?user_id={$user->id}");

        // Assert response is successful
        $response->assertStatus(200);

        // Assert view has correct data
        $response->assertViewHas('user', $user);
        $response->assertViewHas('matches');

        // Assert matches collection is empty
        $matches = $response->viewData('matches');
        $this->assertEquals(0, $matches->count());
    }

    public function test_index_uses_default_user_when_no_id_provided()
    {
        // Create user with ID 1 (default)
        $user = User::factory()->create(['id' => 1]);
        $potentialMatch = User::factory()->create();

        UserMatch::create([
            'user_id' => $user->id,
            'potential_match_id' => $potentialMatch->id,
            'compatibility_score' => 75,
            'processed_at' => now(),
        ]);

        // Make request without user_id parameter
        $response = $this->get('/matches');

        // Assert response is successful
        $response->assertStatus(200);

        // Assert default user is used
        $response->assertViewHas('user', $user);

        // Assert matches are returned
        $matches = $response->viewData('matches');
        $this->assertEquals(1, $matches->count());
    }

    public function test_index_returns_404_for_nonexistent_user()
    {
        // Make request with non-existent user ID
        $response = $this->get('/matches?user_id=999');

        // Assert response is 404 Not Found
        $response->assertStatus(404);
    }
}
