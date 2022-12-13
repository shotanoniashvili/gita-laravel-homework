<div class="row align-content-center border-bottom mx-2">
    <div class="col-10 my-2">
        <div class="tweet-author">
            <a href="{{ route('tweets.show', $tweet->id) }}" class="text-primary">
                {{ $tweet->user->name }}
            </a>
        </div>
        <div class="tweet-content">
            <strong>({{ $tweet->likes->count() }} likes)</strong>
            @if(auth()->user()?->id === $tweet->user_id)
                <strong>(my post)</strong>
            @endif
            @if(auth()->user()?->savedTweets->where('id', $tweet->id)->count() > 0)
                <strong>(saved)</strong>
            @endif
            <div>@if($tweet->created_at != $tweet->updated_at) (edited) @endif {!! $tweet->content !!}</div>
        </div>
        <div class="tweet-footer d-flex">
            <div>
                @if($tweet->likes->where('user_id', auth()->user()?->id)->count() > 0)
                    <form action="{{ route('tweets.unlike', $tweet) }}" method="post">
                        @csrf
                        <button class="btn btn-outline-secondary">
                            Unlike ({{ $tweet->likes->count() }} likes)
                        </button>
                    </form>
                @elseif(auth()->user())
                    <form action="{{ route('tweets.like', $tweet) }}" method="post">
                        @csrf
                        <button class="btn btn-outline-secondary">
                            Like ({{ $tweet->likes->count() }} likes)
                        </button>
                    </form>
                @endif
            </div>
            <div class="ms-2">
                <button class="btn btn-outline-secondary" onclick="toggleDisplay('replies_' + {{ $tweet->id }})">
                    Replies ({{ $tweet->replies->count() }} replies)
                </button>
            </div>
        </div>
        <div class="ms-4 mt-3 tweet-replies @if(!$errors->has('content_' . $tweet->id) && $showReplies == 0) d-none @endif" id="replies_{{ $tweet->id }}">
            @forelse($tweet->replies as $reply)
                <div class="tweet-reply">
                    <div class="replier">
                        <a class="text-primary" href="{{ route('profile', $reply->user->username) }}">
                            {{ $reply->user->name }} ({{ $reply->created_at->format('d.m.Y H:i') }})
                        </a>
                    </div>
                    <div class="text">{{ $reply->content }}</div>
                </div>
            @empty
                {{ __('tweets.replies.not-found') }}
            @endforelse

            <div class="reply-tweet-container mt-2">
                <form action="{{ route('tweets.reply', $tweet->id) }}" method="post">
                    <div class="input-group">
                        @csrf
                        <input type="text" id="content_{{ $tweet->id }}" name="content_{{ $tweet->id }}" class="form-control @error('content_' . $tweet->id) is-invalid @enderror"
                               placeholder="Enter tweet reply here..." value="{{ old('content_' . $tweet->id) }}" required>
                        <button type="submit" class="btn btn-outline-secondary">Reply</button>
                    </div>
                    @error('content_' . $tweet->id)
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </form>
            </div>
        </div>
    </div>
    <div class="col-2 my-2">
        <div class="dropdown text-right">
            <button class="btn btn-secondary dropdown-toggle tweet-actions" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                @if(auth()->user()?->savedTweets->where('id', $tweet->id)->count() > 0)
                    <li>
                        <form action="{{ route('tweets.forget', $tweet->id) }}" method="post">
                            @csrf
                            <button class="dropdown-item" type="submit">Delete from saved</button>
                        </form>
                    </li>
                @else
                    <li>
                        <form action="{{ route('tweets.save', $tweet->id) }}" method="post">
                            @csrf
                            <button class="dropdown-item" type="submit">Save</button>
                        </form>
                    </li>
                @endif
                @can('update', $tweet)
                    <li><a class="dropdown-item" href="{{ route('tweets.edit', $tweet) }}">Edit</a></li>
                    <li>
                        <form action="{{ route('tweets.destroy', $tweet->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="dropdown-item">Delete</button>
                        </form>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
