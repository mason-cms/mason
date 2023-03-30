@extends('workshop.configuration.layout')

@section('main')
    <form
        action="{{ route('workshop.configuration.locale.index') }}"
        method="GET"
    >
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        @lang('locales.title')
                    </h1>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    @include('workshop.partials.search')
                </div>

                <div class="level-item">
                    @include('workshop.partials.paginator')
                </div>

                <div class="level-item">
                    @include('workshop.configuration.locales.partials.buttons.create')
                </div>
            </div>
        </div>

        <hr />

        @if ($locales->count() > 0)
            <div class="columns is-multiline is-card-grid">
                @foreach ($locales as $locale)
                    <div class="column is-4 is-3-desktop">
                        @include('workshop.configuration.locales.partials.card')
                    </div>
                @endforeach
            </div>

            <hr />

            {{ $locales->appends(request()->input())->links('workshop.partials.pagination') }}
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    @lang('locales.noRecords')
                </p>

                <p class="block">
                    @include('workshop.configuration.locales.partials.buttons.create')
                </p>
            </div>
        @endif
    </form>
@endsection
