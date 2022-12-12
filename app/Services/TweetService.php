<?php

namespace App\Services;

use App\Models\Tweets\Like;
use App\Models\Tweets\Reply;
use App\Models\Tweets\Tweet;
use Illuminate\Database\Eloquent\Collection;

class TweetService
{
    public function find(int $tweetId): Tweet {
        return Tweet::findOrFail($tweetId);
    }

    public function feed(int $userId) {
        // TODO
    }

    public function create(array $data): Tweet {
        $tweet = new Tweet($data);
        $tweet->content = $this->transformContent($tweet->content);
        $tweet->save();

        return $tweet;
    }

    public function update(int $tweetId, array $data): Tweet {
        $tweet = Tweet::findOrFail($tweetId);
        $tweet->fill($data);
        $tweet->content = $this->transformContent($tweet->content);
        $tweet->save();

        return $tweet;
    }

    public function destroy(int $tweetId): bool {
        return Tweet::where(['id', $tweetId])->delete();
    }

    public function createReply(int $tweetId, array $data): Collection {
        $tweet = Tweet::findOrFail($tweetId);
        $tweet->replies()->save(new Reply($data));

        return $tweet->replies;
    }

    public function replies(int $tweetId): Collection {
        return Tweet::findOrFail($tweetId)->replies;
    }

    public function like(int $tweetId, int $userId): Collection {
        $tweet = Tweet::findOrFail($tweetId);
        $tweet->likes()->save(new Like([
            'user_id' => $userId
        ]));

        return $tweet->likes;
    }

    public function unlike(int $tweetId, int $userId): Collection {
        $tweet = Tweet::findOrFail($tweetId);
        $tweet->likes->where(['user_id', $userId])->first()->delete();

        return $tweet->likes;
    }

    public function tweetsByUser(int $userId): Collection {
        return Tweet::where('user_id', $userId)->latest();
    }

    protected function transformContent($content): string {
        $regex = '#\bhttps?://[^\s()<>]+(?:\(\w+\)|([^[:punct:]\s]|/))#';

        return preg_replace_callback($regex, function ($matches) {
            return "<a target='_blank' href='{$matches[0]}'>{$matches[0]}</a>";
        }, $content);
    }
}
