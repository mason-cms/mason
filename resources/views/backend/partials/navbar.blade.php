@php
    $requestUri = request()->getUri();
@endphp

<nav
    class="navbar is-primary"
    role="navigation"
>
    <div class="navbar-brand">
        <a
            class="navbar-item"
            href="{{ route('workshop.dashboard') }}"
        >
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

    <div
        id="primary-menu"
        class="navbar-menu"
    >
        <div class="navbar-start">
            <a
                href="{{ $routeUri = route('workshop.dashboard') }}"
                class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
            >
                @icon(\App\Http\Controllers\Backend\DashboardController::ICON, 'has-text-success')
                <span>@lang('dashboard.title')</span>
            </a>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    @icon(\App\Models\Entry::ICON, 'has-text-success')
                    <span>@lang('entries.title')</span>
                </a>

                <div class="navbar-dropdown">
                    @foreach (\App\Models\EntryType::all() as $entryType)
                        <a
                            href="{{ $routeUri = route('workshop.entries.index', [$entryType]) }}"
                            class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
                        >
                            @isset($entryType->icon_class)
                                @icon($entryType->icon_class)
                            @endisset

                            <span>{{ $entryType }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    @icon(\App\Models\Taxonomy::ICON, 'has-text-success')
                    <span>@lang('taxonomies.title')</span>
                </a>

                <div class="navbar-dropdown">
                    @foreach (\App\Models\TaxonomyType::all() as $taxonomyType)
                        <a
                            href="{{ $routeUri = route('workshop.taxonomies.index', [$taxonomyType]) }}"
                            class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
                        >
                            @isset($taxonomyType->icon_class)
                                @icon($taxonomyType->icon_class)
                            @endisset

                            <span>{{ $taxonomyType }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <a
                href="{{ $routeUri = route('workshop.medium.index') }}"
                class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
            >
                @icon(\App\Models\Medium::ICON, 'has-text-success')
                <span>@lang('media.title')</span>
            </a>

            <a
                href="{{ $routeUri = route('workshop.menus.index') }}"
                class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
            >
                @icon(\App\Models\Menu::ICON, 'has-text-success')
                <span>@lang('menus.title')</span>
            </a>

            <a
                href="{{ $routeUri = route('workshop.blocks.index') }}"
                class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
            >
                @icon(\App\Models\Block::ICON, 'has-text-success')
                <span>@lang('blocks.title')</span>
            </a>

            <a
                href="{{ $routeUri = route('workshop.users.index') }}"
                class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
            >
                @icon(\App\Models\User::ICON, 'has-text-success')
                <span>@lang('users.title')</span>
            </a>

            <a
                href="{{ $routeUri = route('workshop.configuration.general') }}"
                class="navbar-item {{ $routeUri === $requestUri ? 'is-active' : '' }}"
            >
                @icon(\App\Http\Controllers\Backend\ConfigurationController::ICON, 'has-text-success')
                <span>@lang('configuration.title')</span>
            </a>
        </div>

        <div class="navbar-end">
            <a
                href="{{ route('home') }}"
                class="navbar-item"
                target="_blank"
            >
                <span>{{ config('site.name') }}</span>
                @icon('fa-arrow-up-right-from-square')
            </a>

            <form
                class="navbar-item"
                action="{{ route('logout') }}"
                method="POST"
            >
                @csrf

                <button
                    class="button is-small is-warning"
                    type="submit"
                >
                    <span>@lang('auth.log_out')</span>
                    @icon('fa-right-from-bracket')
                </button>
            </form>
        </div>
    </div>
</nav>
