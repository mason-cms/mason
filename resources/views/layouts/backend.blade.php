<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    data-request-uri="{{ $requestUri = request()->getUri() }}"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" rel="stylesheet">

        @if ($fontawesomeKit = config('services.fontawesome.kit'))
            <script src="https://kit.fontawesome.com/{!! $fontawesomeKit !!}.js" crossorigin="anonymous"></script>
        @endif

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="backend">
        <nav class="navbar is-primary" role="navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="{{ route('backend.dashboard') }}">
                    <strong>Mason</strong><span class="has-text-success">&times;</span>CMS
                </a>

                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="primary-menu">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="primary-menu" class="navbar-menu">
                <div class="navbar-start">
                    <a
                        href="{{ $routeUri = route('backend.dashboard') }}"
                        class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
                    >
                        <span class="icon has-text-success"><i class="fa-light fa-gauge"></i></span>
                        <span>{{ __('backend.dashboard.title') }}</span>
                    </a>

                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            <span class="icon has-text-success"><i class="fa-light {{ \App\Models\Entry::ICON }}"></i></span>
                            <span>{{ __('entries.title') }}</span>
                        </a>

                        <div class="navbar-dropdown">
                            @foreach(\App\Models\EntryType::all() as $entryType)
                                <a
                                    href="{{ $routeUri = route('backend.entries.index', [$entryType]) }}"
                                    class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
                                >
                                    @isset($entryType->icon_class)
                                        <span class="icon"><i class="fa-light {{ $entryType->icon_class }}"></i></span>
                                    @endisset

                                    <span>{{ $entryType }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <a
                        href="{{ $routeUri = route('backend.taxonomies.index') }}"
                        class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
                    >
                        <span class="icon has-text-success"><i class="fa-light {{ \App\Models\Taxonomy::ICON }}"></i></span>
                        <span>{{ __('taxonomies.title') }}</span>
                    </a>

                    <a
                        href="{{ $routeUri = route('backend.menus.index') }}"
                        class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
                    >
                        <span class="icon has-text-success"><i class="fa-light {{ \App\Models\Menu::ICON }}"></i></span>
                        <span>{{ __('menus.title') }}</span>
                    </a>

                    <a
                        href="{{ $routeUri = route('backend.users.index') }}"
                        class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
                    >
                        <span class="icon has-text-success"><i class="fa-light {{ \App\Models\User::ICON }}"></i></span>
                        <span>{{ __('users.title') }}</span>
                    </a>

                    <a
                        href="{{ $routeUri = route('backend.settings.index') }}"
                        class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
                    >
                        <span class="icon has-text-success"><i class="fa-light {{ \App\Models\Setting::ICON }}"></i></span>
                        <span>{{ __('settings.title') }}</span>
                    </a>
                </div>

                <div class="navbar-end">
                    <form class="navbar-item" action="{{ route('logout') }}" method="post">
                        @csrf

                        <button class="button is-small" type="submit">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <main id="content">
            @yield('content')
        </main>
    </body>
</html>
