@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Search Result') }}</div>

                <div class="card-body">
                    @forelse($users as $user)
                        <x-user-list-item-component :user="$user"></x-user-list-item-component>
                        @empty
                        {{ __('users.search.not-found') }}
                    @endforelse

                    <div class="mt-4">
                        {{ $users->onEachSide(2)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
