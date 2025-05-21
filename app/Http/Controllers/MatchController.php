<?php

namespace App\Http\Controllers;

use App\Events\MatchCreated;
use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        // return 'Hello';
        //return response('Hello', 200)
        //->header('Content-Type', 'text/plain');

        $userId = $request->input('user_id', 1); // Default to first user
        $user = User::findOrFail($userId);
        $matches = UserMatch::where('user_id', $userId)
            ->with('potentialMatch')
            ->orderByDesc('compatibility_score')
            ->get();

        return view('matches.index', [
            'user' => $user,
            'matches' => $matches,
        ]);
    }

    public function store(Request $request)
    {
        $match = UserMatch::create([
            'user_id' => $request->input('user_id', 1),
            'potential_match_id' => $request->matched_user_id,
            'compatibility_score' => $request->input('compatibility_score', 0),
            'processed_at' => now(),
        ]);

        event(new MatchCreated($match));

        return response()->json($match, 201);
    }
}
