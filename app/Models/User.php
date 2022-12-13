<?php

namespace App\Models;

use App\Models\Tweets\Tweet;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_public',
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
    ];

    public function tweets(): HasMany {
        return $this->hasMany(Tweet::class, 'user_id');
    }

    public function follows(): BelongsToMany {
        return $this->belongsToMany(User::class, 'user_followers', 'user_id', 'follows_user_id');
    }

    public function followers(): BelongsToMany {
        return $this->belongsToMany(User::class, 'user_followers', 'follows_user_id', 'user_id');
    }

    public function savedTweets() {
        return $this->belongsToMany(Tweet::class, 'user_saved_tweets', 'user_id', 'tweet_id');
    }
}
