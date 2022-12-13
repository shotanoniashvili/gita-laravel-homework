<div class="my-4 row align-content-center">
    <div class="col-10 my-2">
        <a class="d-flex align-items-center justify-between" href="{{ route('profile', $user->username) }}">
            <div>{{ $user->name }}

                @if(auth()->user()?->followers->where('id', $user->id)->count() > 0)
                    (is following you)
                @endif
            </div>

            <div>
                {{ $user->tweets->count() }} tweets

                @if($user->tweets->count() > 0)
                    (latest: {{ $user->tweets->last()->created_at->format('d.m.Y H:i') }})
                @endif
            </div>
        </a>
    </div>
    <div class="col-2 text-right">
        @if($user->followers->where('id', auth()->user()?->id)->count() > 0)
            <a class="btn btn-secondary" href="{{ route('users.unfollow', $user) }}">
                Unfollow
            </a>
        @else
            <a class="btn btn-primary" href="{{ route('users.follow', $user) }}">
                Follow
            </a>
        @endif
    </div>
</div>
