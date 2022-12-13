<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use App\Http\Requests\TweetRequest;
use App\Http\Resources\BaseResource;
use App\Services\TweetService;
use Exception;
use Faker\Provider\Base;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class TweetController extends Controller
{
    public function __construct(private TweetService $tweetService)
    {
    }

    public function index(Request $request) {
        $tweets = $this->tweetService->feed($request->user()->id)->paginate();

        return new BaseResource('', true, $tweets);
    }

    public function store(TweetRequest $request) {
        try {
            $tweet = $this->tweetService->create($request->user()->id, $request->validated());

            return new BaseResource(__('tweets.create.success'), true, $tweet);
        } catch (Exception $e) {
            Log::error(__('tweets.create.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            return new BaseResource(__('tweets.create.error'), false);
        }
    }

    public function show(int $tweetId) {
        $tweet = $this->tweetService->find($tweetId, ['likes', 'replies', 'user']);

        return new BaseResource('', true, $tweet);
    }

    public function replies(int $tweetId) {
        $tweet = $this->tweetService->find($tweetId, ['replies']);

        return new BaseResource('', true, $tweet->replies);
    }

    public function storeReply(ReplyRequest $request, int $tweetId) {
        try {
            $data = $request->validated();

            $reply = $this->tweetService->createReply($tweetId, $data);

            return new BaseResource(__('tweets.replies.success'), true, $reply);
        } catch (Exception $e) {
            Log::error(__('tweets.replies.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            return new BaseResource(__('tweets.replies.error'), false);
        }
    }

    public function like(Request $request, int $tweetId) {
        try {
            $like = $this->tweetService->like($request->user()->id, $tweetId);

            return new BaseResource(__('tweets.like.success'), true, $like);
        } catch (Exception $e) {
            Log::error(__('tweets.like.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            return new BaseResource(__('tweets.like.error'), false);
        }
    }

    public function unlike(Request $request, int $tweetId) {
        try {
            $like = $this->tweetService->unlike($request->user()->id, $tweetId);

            return new BaseResource(__('tweets.unlike.success'), true);
        } catch (Exception $e) {
            Log::error(__('tweets.unlike.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            return new BaseResource(__('tweets.unlike.error'), false);
        }
    }
}
