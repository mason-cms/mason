<div class="card">
    @if ($media->is_image)
        @isset($media->url)
            <div class="card-image">
                <figure class="image">
                    <a href="{{ route('backend.medium.show', [$media]) }}">
                        <img
                            src="{{ $media->url }}"
                            alt="{{ $media->title }}"
                        />
                    </a>
                </figure>
            </div>
        @endisset
    @endif

    <div class="card-content">
        <div class="block">
            <h2 class="title is-2">
                <a href="{{ route('backend.medium.show', [$media]) }}">
                    {{ $media->title }}
                </a>
            </h2>

            @isset($media->relative_url)
                <div class="subtitle">
                    {{ $media->relative_url }}
                </div>
            @endisset
        </div>

        <div class="block">
            <div class="field is-grouped is-grouped-multiline">
                @isset($media->locale)
                    <div
                        class="control"
                        title="@lang('media.attributes.locale')"
                    >
                        @icon('fa-language')
                        <span>{{ $media->locale }}</span>
                    </div>
                @endisset

                @isset($media->content_type)
                    <div class="control">
                        @icon('fa-file-circle-question')
                        <span>{{ $media->content_type }}</span>
                    </div>
                @endisset

                @isset($media->filesize)
                    <div class="control">
                        @icon('fa-weight-scale')
                        <span>{{ $media->filesize }}</span>
                    </div>
                @endisset

                @isset($media->created_at)
                    <div class="control">
                        @icon('fa-calendar')
                        <span>{{ $media->created_at }}</span>
                    </div>
                @endisset
            </div>
        </div>
    </div>

    <footer class="card-footer">
        <a
            class="card-footer-item"
            href="{{ $media->url }}"
            target="_blank"
        >
            @icon('fa-arrow-up-right-from-square')
            <span class="is-hidden-mobile">@lang('media.actions.view.label')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('backend.medium.edit', [$media]) }}"
        >
            @icon('fa-pencil')
            <span class="is-hidden-mobile">@lang('media.actions.edit.label')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('backend.medium.destroy', [$media]) }}"
            data-confirm="@lang('general.confirm')"
            data-method="DELETE"
        >
            @icon('fa-trash-can')
            <span class="is-hidden-mobile">@lang('media.actions.destroy.label')</span>
        </a>
    </footer>
</div>
