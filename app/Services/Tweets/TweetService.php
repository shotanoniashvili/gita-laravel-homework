<?php

namespace App\Services\Tweets;

use App\Models\Tweets\Tweet;

class TweetService
{
    public static function show(Tweet $tweet, array $data) {
        // TODO
    }

    public static function create(array $data) {
        $tweet = new Tweet($data);
        $tweet->content = self::transformContent($tweet->content);

        return $tweet->save();
    }

    public static function update(Tweet $tweet, array $data) {
        // TODO
    }

    public static function destroy(Tweet $tweet, array $data) {
        // TODO
    }

    protected static function transformContent($content) {
        $regex = '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#';

        return preg_replace_callback($regex, function ($matches) {
            return "<a target='_blank' href='{$matches[0]}'>{$matches[0]}</a>";
        }, $content);
    }
}
