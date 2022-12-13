<?php

namespace App\Services;

use App\Models\Tweets\Like;
use App\Models\Tweets\Reply;
use App\Models\Tweets\Tweet;
use App\Models\User;
use App\Notifications\CreateTweetNotification;
use App\Notifications\TweetLikeNotification;
use App\Notifications\TweetReplyNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;

class TweetService
{
    public function find(int $tweetId, array $relations = []): Tweet
    {
        return Tweet::with($relations)->where('id', $tweetId)->firstOrFail();
    }

    public function feed(int $userId) {
        return Tweet::with('user', 'likes', 'replies')->latest();
    }

    public function create(int $userId, array $data): Tweet {
        $tweet = new Tweet($data);
        $tweet->user_id = $userId;
        $tweet->save();

        $user = User::findOrFail($userId);

        Notification::send($user->followers, new CreateTweetNotification($tweet));

        return $tweet;
    }

    public function update(int $tweetId, array $data): Tweet {
        $tweet = Tweet::findOrFail($tweetId);

        $tweet->update($data);

        return $tweet;
    }

    public function destroy(int $tweetId): bool {
        return Tweet::where('id', $tweetId)->delete();
    }

    public function createReply(int $tweetId, array $data): Collection {
        $tweet = Tweet::findOrFail($tweetId);

        $tweet->replies()->save(new Reply($data));

        if ($tweet->user->id != $data['user_id']) {
            Notification::send($tweet->user, new TweetReplyNotification($tweet->replies->last()));
        }

        return $tweet->replies;
    }

    public function replies(int $tweetId): Collection {
        return Tweet::findOrFail($tweetId)->replies;
    }

    public function like(int $userId, int $tweetId): Collection {
        $tweet = Tweet::findOrFail($tweetId);
        $tweet->likes()->save(new Like([
            'user_id' => $userId
        ]));

        if ($tweet->user->id != $userId) {
            Notification::send($tweet->user, new TweetLikeNotification($tweet->likes->last()));
        }

        return $tweet->likes;
    }

    public function unlike(int $userId, int $tweetId): Collection {
        $tweet = Tweet::findOrFail($tweetId);
        $tweet->likes->where('user_id', $userId)->first()->delete();

        return $tweet->likes;
    }

    public function tweetsByUser(int $userId): Collection {
        return Tweet::where('user_id', $userId)->latest();
    }

    public function savedTweets(int $userId) {
        $user = User::with('savedTweets')->where('id', $userId)->first();

        return $user->savedTweets();
    }

    public function saveToList(int $userId, int $tweetId) {
        $user = User::findOrFail($userId);

        return $user->savedTweets()->attach($tweetId);
    }

    public function deleteFromList(int $userId, int $tweetId) {
        $user = User::findOrFail($userId);

        return $user->savedTweets()->detach($tweetId);
    }
}
