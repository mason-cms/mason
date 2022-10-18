<div class="card locale locale-{{ $locale->getKey() }}">
    <div class="card-content">
        <div class="block">
            <div>
                @if ($locale->is_default)
                    <span title="@lang('locales.attributes.is_default')">
                        @icon('fa-star')
                    </span>
                @endif

                <span class="locale-name">
                    {{ $locale->name }}
                </span>
            </div>

            <h2 class="title is-2 locale-title">
                <a href="{{ route('backend.configuration.locale.edit', [$locale]) }}">
                    {{ $locale->title }}
                </a>
            </h2>
        </div>
    </div>

    <div class="card-spacer"></div>

    <div class="card-footer">
        <a
            class="card-footer-item"
            href="{{ route('backend.configuration.locale.edit', [$locale]) }}"
        >
            @icon('fa-pencil')
            <span class="is-hidden-mobile">@lang('locales.actions.edit.label')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('backend.configuration.locale.destroy', [$locale]) }}"
            data-confirm="@lang('general.confirm')"
            data-method="DELETE"
        >
            @icon('fa-trash-can')
            <span class="is-hidden-mobile">@lang('locales.actions.destroy.label')</span>
        </a>
    </div>
</div>
