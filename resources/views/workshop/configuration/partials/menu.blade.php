@php
    $currentRouteName = request()->route()->getName();
@endphp

<nav class="menu">
    <p class="menu-label">
        @icon(\App\Http\Controllers\Workshop\ConfigurationController::ICON)
        <span>@lang('configuration.title')</span>
    </p>

    <ul class="menu-list">
        <li>
            <a
                href="{{ route($routeName = 'workshop.configuration.general') }}"
                class="{{ $routeName === $currentRouteName ? 'is-active' : '' }}"
            >
                @lang('configuration.general.title')
            </a>
        </li>

        <li>
            <a
                href="{{ route($routeName = 'workshop.configuration.setting.index') }}"
                class="{{ $routeName === $currentRouteName ? 'is-active' : '' }}"
            >
                @lang('settings.title')
            </a>
        </li>

        <li>
            <a
                href="{{ route($routeName = 'workshop.configuration.locale.index') }}"
                class="{{ $routeName === $currentRouteName ? 'is-active' : '' }}"
            >
                @lang('locales.title')
            </a>
        </li>

        <li>
            <a
                href="{{ route($routeName = 'workshop.configuration.entry-type.index') }}"
                class="{{ $routeName === $currentRouteName ? 'is-active' : '' }}"
            >
                @lang('entryTypes.title')
            </a>
        </li>

        <li>
            <a
                href="{{ route($routeName = 'workshop.configuration.taxonomy-type.index') }}"
                class="{{ $routeName === $currentRouteName ? 'is-active' : '' }}"
            >
                @lang('taxonomyTypes.title')
            </a>
        </li>
    </ul>
</nav>
