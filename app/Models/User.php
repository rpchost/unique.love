<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

    protected $touches = ['roles']; // Enable pivot events
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'age',
        'active',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
    ];

    public function preferences()
    {
        return $this->hasOne(UserPreference::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function interests()
    {
        return $this->belongsToMany(Interest::class);
    }

    public function matches()
    {
        return $this->hasMany(UserMatch::class);
    }

    public function potentialMatches()
    {
        return $this->hasMany(UserMatch::class, 'potential_match_id');
    }
}
