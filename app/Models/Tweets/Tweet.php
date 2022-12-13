<?php

namespace App\Models\Tweets;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes() {
        return $this->hasMany(Like::class, 'tweet_id');
    }

    public function replies() {
        return $this->hasMany(Reply::class, 'tweet_id');
    }

    public function getContentAttribute() {
        $regex = '#\bhttps?://[^\s()<>]+(?:\(\w+\)|([^[:punct:]\s]|/))#';

        return preg_replace_callback($regex, function ($matches) {
            return "<a target='_blank' href='{$matches[0]}'>{$matches[0]}</a>";
        }, $this->attributes['content']);
    }

    public function getPlainTextAttribute() {
        return $this->attributes['content'];
    }
}
