<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Http\Requests\TweetRequest;
use App\Models\Tweets\Tweet;
use App\Models\User;
use App\Services\TweetService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TweetController extends Controller
{
    public function __construct(private TweetService $tweetService)
    {
    }

    public function index(Request $request) {
        $tweets = $this->tweetService->feed($request->user()->id)->paginate();

        return view('home', compact('tweets'));
    }

    public function saved(Request $request) {
        $tweets = $this->tweetService->savedTweets($request->user()->id)->paginate();

        return view('saved-tweets', compact('tweets'));
    }

    public function show(int $tweetId) {
        $tweet = $this->tweetService->find($tweetId, ['likes', 'replies', 'user']);

        $this->authorize('view', $tweet);

        return view('tweets.show', compact('tweet'));
    }

    public function store(TweetRequest $request) {
        try {
            $this->tweetService->create($request->user()->id, $request->validated());

            notify()->success(__('tweets.create.success'));

            return redirect()->back();
        } catch (Exception $e) {
            Log::error(__('tweets.create.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            notify()->error(__('tweets.create.error'));

            return redirect()->back();
        }
    }

    public function edit(int $tweetId) {
        $tweet = $this->tweetService->find($tweetId);

        $this->authorize('update', $tweet);

        return view('tweets.edit', compact('tweet'));
    }

    public function update(TweetRequest $request, int $tweetId) {
        $tweet = $this->tweetService->find($tweetId);

        $this->authorize('update', $tweet);

        try {
            $this->tweetService->update($tweetId, $request->validated());

            notify()->success(__('tweets.update.success'));

            return redirect()->route('tweets.show', $tweetId);
        } catch (Exception $e) {
            Log::error(__('tweets.update.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            notify()->error(__('tweets.update.error'));

            return redirect()->route('tweets.edit', $tweetId);
        }
    }

    public function destroy(int $tweetId) {
        $this->authorize('delete', Tweet::find($tweetId));

        try {
            $this->tweetService->destroy($tweetId);

            notify()->success(__('tweets.destroy.success'));

            return redirect()->route('home');
        } catch (Exception $e) {
            Log::error(__('tweets.destroy.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            notify()->error(__('tweets.destroy.error'));

            return redirect()->route('home');
        }
    }

    public function save(Request $request, int $tweetId) {
        try {
            $this->tweetService->saveToList($request->user()->id, $tweetId);

            notify()->success('tweets.save.saved.success');

            return redirect()->back();
        } catch (Exception $e) {
            Log::error(__('tweets.save.saved.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            notify()->error(__('tweets.save.saved.error'));

            return redirect()->back();
        }
    }

    public function forget(Request $request, int $tweetId) {
        try {
            $this->tweetService->deleteFromList($request->user()->id, $tweetId);

            notify()->success(__('tweets.save.forgotten.success'));

            return redirect()->back();
        } catch (Exception $e) {
            Log::error(__('tweets.save.forgotten.error') . PHP_EOL . $e->getMessage(), $e->getTrace());

            notify()->error(__('tweets.save.forgotten.error'));

            return redirect()->back();
        }
    }
}
