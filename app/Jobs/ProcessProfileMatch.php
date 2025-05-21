<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessProfileMatch implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
        public array $preferences = []
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get potential matches based on preferences
        $potentialMatches = User::where('id', '!=', $this->user->id)
            ->where('gender', $this->preferences['interested_in'] ?? $this->user->preferences->interested_in ?? 'female')
            ->whereBetween('age', $this->preferences['age_range'] ?? [18, 99])
            // Add more filtering based on preferences
            ->limit(50)
            ->get();

        // Calculate compatibility scores
        foreach ($potentialMatches as $potentialMatch) {
            $score = $this->calculateCompatibilityScore($potentialMatch);

            // Store match with score in database
            UserMatch::updateOrCreate(
                ['user_id' => $this->user->id, 'potential_match_id' => $potentialMatch->id],
                ['compatibility_score' => $score, 'processed_at' => now()]
            );
        }
    }

    /**
     * Calculate compatibility score between users.
     */
    private function calculateCompatibilityScore(User $potentialMatch): int
    {
        // Implement your matching algorithm here
        // This is a simplified example
        $score = 0;

        // Location proximity
        if (
            $this->user->location && $potentialMatch->location &&
            $this->user->location->isNear($potentialMatch->location)
        ) {
            $score += 20;
        }

        // Common interests
        if ($this->user->interests && $potentialMatch->interests) {
            $commonInterests = array_intersect(
                $this->user->interests->pluck('id')->toArray(),
                $potentialMatch->interests->pluck('id')->toArray()
            );
            $score += count($commonInterests) * 5;
        }

        // Other compatibility factors...

        return min($score, 100); // Cap at 100
    }

    private function createMatch(User $user, User $potentialMatch, int $score): void
    {
        $match = UserMatch::create([
            'user_id' => $user->id,
            'potential_match_id' => $potentialMatch->id,
            'compatibility_score' => $score,
            'processed_at' => now(),
        ]);

        // Dispatch the event
        event(new MatchCreated($match, $user, $potentialMatch));
    }
}
