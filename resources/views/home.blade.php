@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create tweet</div>

                <div class="card-body">
                    <form action="{{ route('tweets.store') }}" method="post">
                        <div class="input-group">
                            @csrf
                            <input type="text" id="content" name="content" class="form-control @error('content') is-invalid @enderror"
                                   placeholder="Enter tweet content here... (max. 140 characters)" value="{{ old('content') }}" required autofocus>
                            <button type="submit" class="btn btn-outline-secondary">Post</button>
                        </div>
                        @error('content')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-header">Feed</div>

                <div class="card-body" id="feed">
                    @forelse($tweets as $tweet)
                        <x-tweet-list-item-component :tweet="$tweet" :showReplies="0"></x-tweet-list-item-component>
                    @empty
                        {{ __('tweets.not-found') }}
                    @endforelse
{{--                    <div class="mt-4 d-flex justify-center">--}}
{{--                        {{ $tweets->onEachSide(2)->links() }}--}}
{{--                    </div>--}}
                    <div class="mt-2 text-center">
                        @if(!$tweets->onFirstPage())
                            <a href="{{ $tweets->previousPageUrl() }}" class="btn btn-secondary mr-2">
                                Previous page
                            </a>
                        @endif
                        @if($tweets->hasMorePages())
                            <a href="{{ $tweets->nextPageUrl() }}" class="btn btn-primary">
                                Next Page (Load More)
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
