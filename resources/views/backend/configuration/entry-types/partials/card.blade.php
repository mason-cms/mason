<div class="card entry-type entry-type-{{ $entryType->getKey() }}">
    <div class="card-content">
        <div class="block">
            <h2 class="title is-2 entry-title">
                <a href="{{ route('workshop.configuration.entry-type.edit', [$entryType]) }}">
                    @isset($entryType->icon_class)
                        @icon($entryType->icon_class, 'entry-type-icon')
                    @endisset

                    <span>{{ $entryType->plural_title }}</span>
                </a>
            </h2>
        </div>
    </div>

    <div class="card-spacer"></div>

    <div class="card-footer">
        <a
            class="card-footer-item"
            href="{{ route('workshop.configuration.entry-type.edit', [$entryType]) }}"
        >
            @icon('fa-pencil')
            <span class="is-hidden-mobile">@lang('entryTypes.actions.edit.label')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('workshop.configuration.entry-type.destroy', [$entryType]) }}"
            data-confirm="@lang('general.confirm')"
            data-method="DELETE"
        >
            @icon('fa-trash-can')
            <span class="is-hidden-mobile">@lang('entryTypes.actions.destroy.label')</span>
        </a>
    </div>
</div>
