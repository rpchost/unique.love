<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'city',
        'state',
        'country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isNear(Location $otherLocation, $maxDistance = 50)
    {
        // Simple distance calculation (not accurate for long distances)
        $latDiff = abs($this->latitude - $otherLocation->latitude);
        $lngDiff = abs($this->longitude - $otherLocation->longitude);

        // Very simplified proximity check
        return $latDiff < 0.5 && $lngDiff < 0.5;

        // For a real app, use a proper distance calculation:
        // return $this->calculateDistance($otherLocation) <= $maxDistance;
    }
}
