<?php

namespace App\Models\Tweets;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes() {
        return $this->hasMany(Like::class, 'tweet_id');
    }

    public function replies() {
        return $this->hasMany(Reply::class, 'tweet_id');
    }
}
