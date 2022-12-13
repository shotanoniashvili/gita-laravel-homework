@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>

                @if($user->id === auth()->user()->id)
                <div class="card-body text-right">
                    <a class="btn btn-outline-info" href="{{ route('profile.edit') }}">Edit Profile</a>
                </div>
                @endif

                <div class="card-body">
                    <x-user-list-item-component :user="$user"></x-user-list-item-component>
                </div>
            </div>
        </div>

        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-header">Feed</div>

                <div class="card-body">
                    @forelse($tweets as $tweet)
                        <x-tweet-list-item-component :tweet="$tweet" :showReplies="0"></x-tweet-list-item-component>
                    @empty
                        {{ __('tweets.not-found') }}
                    @endforelse

                    <div class="mt-4">
                        {{ $tweets->onEachSide(2)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
