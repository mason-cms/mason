@extends('layouts.backend')

@section('content')
    <form
        class="section"
        action="{{ route('backend.entries.index', [$entryType]) }}"
        method="GET"
    >
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <div>
                        <h1 class="title is-1">
                            <a href="{{ route('backend.entries.index', [$entryType]) }}">
                                {{ $entryType }}
                            </a>
                        </h1>

                        <div class="pagination-count">
                            {{ trans_choice('entries.pagination', $entries->count() , ['total' => $total]) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    @include('backend.partials.entries.search')
                </div>

                <div class="level-item">
                    @include('backend.partials.entries.filters')
                </div>

                <div class="level-item">
                    @include('backend.partials.entries.paginator')
                </div>

                <div class="level-item">
                    @include('backend.partials.entries.buttons.create')
                </div>
            </div>
        </div>

        <hr />

        @if ($entries->count() > 0)
            <div class="columns is-multiline same-height-cards">
                @foreach($entries as $entry)
                    <div class="column is-3">
                        @include('backend.partials.entries.card')
                    </div>
                @endforeach
            </div>

            <hr />

            {{ $entries->appends(request()->input())->links('backend.partials.pagination') }}
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    {{ __('entries.no_records') }}
                </p>

                <p class="block">
                    @include('backend.partials.entries.buttons.create')
                </p>
            </div>
        @endif
    </form>
@endsection
