<div class="card block-{{ $block->getKey() }}">
    <div class="card-content">
        <div class="block">
            <h3 class="title is-3">
                <a href="{{ route('backend.blocks.edit', [$block]) }}">
                    {{ $block->title ?? __('blocks.untitled') }}
                </a>
            </h3>
        </div>

        <div class="block block-meta">
            <div class="field is-grouped is-grouped-multiline">
                @isset($block->location)
                    <div
                        class="control block-location"
                        title="@lang('blocks.attributes.location')"
                    >
                        @icon('fa-square')
                        <span>{{ $block->location_info->title }}</span>
                    </div>
                @endisset

                @isset($block->locale)
                    <div
                        class="control block-locale"
                        title="@lang('blocks.attributes.locale')"
                    >
                        @icon('fa-language')
                        <span>{{ $block->locale }}</span>
                    </div>
                @endisset
            </div>
        </div>
    </div>

    <div class="card-footer">
        <a
            class="card-footer-item"
            href="{{ route('backend.blocks.edit', [$block]) }}"
        >
            @icon('fa-pencil')
            <span class="is-hidden-mobile">@lang('blocks.actions.edit.label')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('backend.blocks.destroy', [$block]) }}"
            data-confirm="@lang('general.confirm')"
        >
            @icon('fa-trash-can')
            <span class="is-hidden-mobile">@lang('blocks.actions.destroy.label')</span>
        </a>
    </div>
</div>
