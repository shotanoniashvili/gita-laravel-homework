<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @notifyCss
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item me-5">
                                <form action="{{ route('search') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" id="searchName" name="search" class="form-control"
                                               placeholder="Search users by name / username">
                                        <button type="submit" class="btn btn-outline-secondary">Search</button>
                                    </div>
                                </form>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('tweets.saved') }}">Saved Tweets</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('my-connections') }}">My Connections</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('search') }}">Explore Users</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarNotificationDropdown" class="position-relative nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-bell"></i>
                                    @if(auth()->user()->notifications()->whereNull('read_at')->count() > 0)
                                        <span class="badge rounded-pill bg-danger notification-count">+{{ auth()->user()->notifications()->whereNull('read_at')->count() }}</span>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarNotificationDropdown">
                                    @forelse(auth()->user()->notifications()->orderBy('read_at')->orderByDesc('created_at')->take(20)->get() as $notification)
                                        <a class="dropdown-item" @if(!$notification->read_at) onclick="sendGetRequest('{{ route('notifications.read', $notification->id) }}')" @endif
                                            href="{{ $notification->data['url'] }}">
                                            @if(!$notification->read_at)
                                                <strong>(new) {{ $notification->data['text'] }}</strong>
                                            @else
                                                {{ $notification->data['text'] }}
                                            @endif
                                        </a>
                                    @empty
                                        <span class="dropdown-item">{{ __('notifications.not-found') }}</span>
                                    @endforelse
                                    @if(auth()->user()->notifications->count() > 0)
                                        <a class="dropdown-item border-top text-center" href="{{ route('notifications.read') }}">
                                            Mark all as read
                                        </a>
                                    @endif
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ auth()->user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('me') }}">My Profile</a>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <x:notify-messages />
    @notifyJs
</body>
</html>
