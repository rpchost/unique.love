<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMatch extends Model
{
    use HasFactory;

    protected $table = 'matches'; // Keep using the matches table

    protected $fillable = [
        'user_id',
        'potential_match_id',
        'compatibility_score',
        'user_liked',
        'match_liked',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function potentialMatch()
    {
        return $this->belongsTo(User::class, 'potential_match_id');
    }
}
