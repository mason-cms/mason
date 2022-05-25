@php
    $requestUri = request()->getUri();
@endphp

<nav class="navbar is-primary" role="navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('backend.dashboard') }}">
            <strong>Mason</strong><span class="has-text-success">&times;</span>CMS
        </a>

        <a
            class="navbar-burger"
            role="button"
            aria-label="menu"
            aria-expanded="false"
            data-target="primary-menu"
        >
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

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    <span class="icon has-text-success"><i class="fa-light {{ \App\Models\Taxonomy::ICON }}"></i></span>
                    <span>{{ __('taxonomies.title') }}</span>
                </a>

                <div class="navbar-dropdown">
                    @foreach(\App\Models\TaxonomyType::all() as $taxonomyType)
                        <a
                            href="{{ $routeUri = route('backend.taxonomies.index', [$taxonomyType]) }}"
                            class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
                        >
                            @isset($taxonomyType->icon_class)
                                <span class="icon"><i class="fa-light {{ $taxonomyType->icon_class }}"></i></span>
                            @endisset

                            <span>{{ $taxonomyType }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

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
                href="{{ $routeUri = route('backend.configuration.general') }}"
                class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
            >
                <span class="icon has-text-success"><i class="fa-light fa-screwdriver-wrench"></i></span>
                <span>{{ __('configuration.title') }}</span>
            </a>
        </div>

        <div class="navbar-end">
            <form class="navbar-item" action="{{ route('logout') }}" method="post">
                @csrf

                <button class="button is-small is-warning" type="submit">
                    <span>{{ __('auth.log_out') }}</span>
                    <span class="icon"><i class="fa-light fa-right-from-bracket"></i></span>
                </button>
            </form>
        </div>
    </div>
</nav>
