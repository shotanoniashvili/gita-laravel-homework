@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Saved tweets') }}</div>

                <div class="card-body">
                    @forelse($tweets as $tweet)
                        <x-tweet-list-item-component :tweet="$tweet"></x-tweet-list-item-component>
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
