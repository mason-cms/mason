<div class="card">
    @isset($entry->cover)
        <div class="card-image">
            <figure class="image">
                <a href="{{ route('backend.entries.edit', [$entry->type, $entry]) }}">
                    <img src="{{ $entry->cover->url }}" alt="{{ $entry->cover->title }}">
                </a>
            </figure>
        </div>
    @endisset

    <div class="card-content">
        <div class="block">
            <h2 class="title is-2 entry-title">
                <a href="{{ route('backend.entries.edit', [$entry->type, $entry]) }}">
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
                    <div class="control entry-author" title="{{ __('entries.attributes.author') }}">
                        <span class="icon"><i class="fa-light fa-user-pen"></i></span>
                        <span>{{ $entry->author }}</span>
                    </div>
                @endisset

                @isset($entry->locale)
                    <div class="control entry-locale" title="{{ __('entries.attributes.locale') }}">
                        <span class="icon"><i class="fa-light fa-language"></i></span>
                        <span>{{ $entry->locale }}</span>
                    </div>
                @endisset

                @isset($entry->status)
                    <div class="control entry-status" title="{{ __('entries.attributes.status') }}">
                        <span class="icon"><i class="fa-light fa-compass-drafting"></i></span>
                        <span>{{ __("entries.statuses.{$entry->status}") }}</span>
                    </div>
                @endisset

                @isset($entry->published_at)
                    <div class="control entry-published-at">
                        <span class="icon"><i class="fa-light fa-calendar-arrow-up"></i></span>
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
            <span class="icon"><i class="fa-light fa-arrow-up-right-from-square"></i></span>
            <span>{{ __('entries.actions.view.label') }}</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('backend.entries.edit', [$entry->type, $entry]) }}"
        >
            <span class="icon"><i class="fa-light fa-pencil"></i></span>
            <span>{{ __('entries.actions.edit.label') }}</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('backend.entries.destroy', [$entry->type, $entry]) }}"
            data-confirm="{{ __('general.confirm') }}"
        >
            <span class="icon"><i class="fa-light fa-trash-can"></i></span>
            <span>{{ __('entries.actions.destroy.label') }}</span>
        </a>
    </div>
</div>
