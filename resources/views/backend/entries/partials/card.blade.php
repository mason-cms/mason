<div class="card entry entry-{{ $entry->getKey() }}">
    @isset($entry->cover)
        <div class="card-image">
            <figure class="image entry-cover">
                <a href="{{ route('workshop.entries.edit', [$entry->type, $entry]) }}">
                    <img
                        src="{{ $entry->cover->url }}"
                        alt="{{ $entry->cover->title }}"
                    />
                </a>
            </figure>
        </div>
    @endisset

    <div class="card-content">
        <div class="block">
            <h2 class="title is-2 entry-title">
                @if ($entry->is_home)
                    <span title="@lang('entries.attributes.is_home')">
                        @icon('fa-house')
                    </span>
                @endif

                <a href="{{ route('workshop.entries.edit', [$entry->type, $entry]) }}">
                    {{ $entry->title }}
                </a>
            </h2>

            <div class="subtitle entry-name">
                {{ $entry->relative_url }}
            </div>
        </div>

        <div class="block entry-meta">
            <div class="field is-grouped is-grouped-multiline">
                @isset($entry->author)
                    <div
                        class="control entry-author"
                        title="@lang('entries.attributes.author')"
                    >
                        @icon('fa-user-pen')
                        <span>{{ $entry->author }}</span>
                    </div>
                @endisset

                @isset($entry->locale)
                    <div
                        class="control entry-locale"
                        title="@lang('entries.attributes.locale')"
                    >
                        @icon('fa-language')
                        <span>{{ $entry->locale }}</span>
                    </div>
                @endisset

                @isset($entry->status)
                    <div
                        class="control entry-status"
                        title="@lang('entries.attributes.status')"
                    >
                        @icon('fa-compass-drafting')
                        <span>@lang("entries.statuses.{$entry->status}")</span>
                    </div>
                @endisset

                @isset($entry->published_at)
                    <div class="control entry-published-at">
                        @icon('fa-calendar')
                        <span>{{ $entry->published_at }}</span>
                    </div>
                @endisset
            </div>
        </div>

        @isset($entry->summary)
            <div class="block entry-summary">
                {!! $entry->summary !!}
            </div>
        @endisset
    </div>

    <div class="card-spacer"></div>

    <div class="card-footer">
        <a
            class="card-footer-item"
            href="{{ $entry->url }}"
            target="_blank"
        >
            @icon('fa-arrow-up-right-from-square')
            <span class="is-hidden-mobile">@lang('entries.actions.view.label')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('workshop.entries.edit', [$entry->type, $entry]) }}"
        >
            @icon('fa-pencil')
            <span class="is-hidden-mobile">@lang('entries.actions.edit.label')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('workshop.entries.destroy', [$entry->type, $entry]) }}"
            data-confirm="@lang('general.confirm')"
        >
            @icon('fa-trash-can')
            <span class="is-hidden-mobile">@lang('entries.actions.destroy.label')</span>
        </a>
    </div>
</div>
