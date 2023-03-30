@extends('workshop.layout')

@section('content')
    <form
        class="section"
        action="{{ route('workshop.entries.index', [$entryType]) }}"
        method="GET"
    >
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <div>
                        <h1 class="title is-1">
                            <a href="{{ route('workshop.entries.index', [$entryType]) }}">
                                @isset($entryType)
                                    @icon($entryType->icon_class)
                                @endisset

                                <span>{{ $entryType }}</span>
                            </a>
                        </h1>

                        <div class="pagination-count has-text-small">
                            {{ trans_choice('entries.pagination', $entries->count() , ['total' => $total]) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    @include('workshop.partials.search')
                </div>

                <div class="level-item">
                    @include('workshop.entries.partials.filters')
                </div>

                <div class="level-item">
                    @include('workshop.partials.paginator')
                </div>

                <div class="level-item">
                    @include('workshop.entries.partials.buttons.create', ['entryType' => $entryType])
                </div>
            </div>
        </div>

        <hr />

        @if ($entries->count() > 0)
            <div class="columns is-multiline is-card-grid">
                @foreach ($entries as $entry)
                    <div class="column is-4 is-3-desktop">
                        @include('workshop.entries.partials.card')
                    </div>
                @endforeach
            </div>

            <hr />

            {{ $entries->appends(request()->input())->links('workshop.partials.pagination') }}
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    @lang('entries.noRecords', ['entryType' => strtolower($entryType->plural_title)])
                </p>

                <p class="block">
                    @include('workshop.entries.partials.buttons.create', ['entryType' => $entryType])
                </p>
            </div>
        @endif
    </form>
@endsection
