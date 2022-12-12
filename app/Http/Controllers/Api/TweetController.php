<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use App\Http\Requests\TweetRequest;

class TweetController extends Controller
{
    public function index() {
        // TODO
    }

    public function store(TweetRequest $request) {
        // TODO
    }

    public function show(int $tweetId) {
        // TODO
    }

    public function replies(int $tweetId) {
        // TODO
    }

    public function storeReply(ReplyRequest $request, int $tweetId) {
        // TODO
    }

    public function like(int $tweetId) {
        // TODO
    }

    public function unlike(int $tweetId) {
        // TODO
    }
}
