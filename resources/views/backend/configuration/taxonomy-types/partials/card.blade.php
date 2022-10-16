<div class="card taxonomy-type taxonomy-type-{{ $taxonomyType->getKey() }}">
    <div class="card-content">
        <div class="block">
            <h2 class="title is-2 entry-title">
                <a href="{{ route('backend.configuration.taxonomy-type.edit', [$taxonomyType]) }}">
                    @isset($taxonomyType->icon_class)
                        @icon($taxonomyType->icon_class, 'taxonomy-type-icon')
                    @endisset

                    <span>{{ $taxonomyType->plural_title }}</span>
                </a>
            </h2>
        </div>
    </div>

    <div class="card-spacer"></div>

    <div class="card-footer">
        <a
            class="card-footer-item"
            href="{{ route('backend.configuration.taxonomy-type.edit', [$taxonomyType]) }}"
        >
            @icon('fa-pencil')
            <span class="is-hidden-mobile">@lang('taxonomyTypes.actions.edit.label')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('backend.configuration.taxonomy-type.destroy', [$taxonomyType]) }}"
            data-confirm="@lang('general.confirm')"
            data-method="DELETE"
        >
            @icon('fa-trash-can')
            <span class="is-hidden-mobile">@lang('taxonomyTypes.actions.destroy.label')</span>
        </a>
    </div>
</div>
