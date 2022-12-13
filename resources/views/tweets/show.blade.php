@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $tweet->user->name }}
                </div>

                <div class="card-body">
                    <x-tweet-list-item-component :tweet="$tweet" :showReplies="1"></x-tweet-list-item-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
