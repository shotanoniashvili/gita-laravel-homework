<?php

namespace App\Models\Tweets;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'tweet_id', 'user_id'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tweet(): BelongsTo {
        return $this->belongsTo(User::class, 'tweet_id');
    }
}
