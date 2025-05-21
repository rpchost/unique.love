<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'interested_in',
        'age_range',
        'distance_preference',
        'interests',
    ];

    protected $casts = [
        'age_range' => 'array',
        'interests' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
