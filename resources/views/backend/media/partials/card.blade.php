<div class="card">
    @if ($medium->is_image)
        @isset($medium->url)
            <div class="card-image">
                <figure class="image">
                    <a href="{{ route('backend.medium.show', [$medium]) }}">
                        <img
                            src="{{ $medium->url }}"
                            alt="{{ $medium->title }}"
                        />
                    </a>
                </figure>
            </div>
        @endisset
    @endif

    <div class="card-content">
        <div class="block">
            <h2 class="title is-2">
                <a href="{{ route('backend.medium.show', [$medium]) }}">
                    {{ $medium->title }}
                </a>
            </h2>

            @isset($medium->relative_url)
                <div class="subtitle">
                    {{ $medium->relative_url }}
                </div>
            @endisset
        </div>

        <div class="block">
            <div class="field is-grouped is-grouped-multiline">
                @isset($medium->locale)
                    <div
                        class="control"
                        title="@lang('media.attributes.locale')"
                    >
                        @icon('fa-language')
                        <span>{{ $medium->locale }}</span>
                    </div>
                @endisset

                @isset($medium->content_type)
                    <div class="control">
                        @icon('fa-file-circle-question')
                        <span>{{ $medium->content_type }}</span>
                    </div>
                @endisset

                @isset($medium->filesize)
                    <div class="control">
                        @icon('fa-weight-scale')
                        <span>{{ $medium->filesize }}</span>
                    </div>
                @endisset

                @isset($medium->created_at)
                    <div class="control">
                        @icon('fa-calendar')
                        <span>{{ $medium->created_at }}</span>
                    </div>
                @endisset
            </div>
        </div>
    </div>

    <footer class="card-footer">
        <a
            class="card-footer-item"
            href="{{ $medium->url }}"
            target="_blank"
        >
            @icon('fa-arrow-up-right-from-square')
            <span class="is-hidden-mobile">@lang('media.actions.view.label')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('backend.medium.edit', [$medium]) }}"
        >
            @icon('fa-pencil')
            <span class="is-hidden-mobile">@lang('media.actions.edit.label')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('backend.medium.destroy', [$medium]) }}"
            data-confirm="@lang('general.confirm')"
            data-method="DELETE"
        >
            @icon('fa-trash-can')
            <span class="is-hidden-mobile">@lang('media.actions.destroy.label')</span>
        </a>
    </footer>
</div>
