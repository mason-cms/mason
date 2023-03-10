@extends('backend.configuration.layout')

@section('main')
    <form
        action="{{ route('backend.configuration.locale.index') }}"
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
                    @include('backend.partials.search')
                </div>

                <div class="level-item">
                    @include('backend.partials.paginator')
                </div>

                <div class="level-item">
                    @include('backend.configuration.locales.partials.buttons.create')
                </div>
            </div>
        </div>

        <hr />

        @if ($locales->count() > 0)
            <div class="columns is-multiline is-card-grid">
                @foreach ($locales as $locale)
                    <div class="column is-4 is-3-desktop">
                        @include('backend.configuration.locales.partials.card')
                    </div>
                @endforeach
            </div>

            <hr />

            {{ $locales->appends(request()->input())->links('backend.partials.pagination') }}
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    @lang('locales.noRecords')
                </p>

                <p class="block">
                    @include('backend.configuration.locales.partials.buttons.create')
                </p>
            </div>
        @endif
    </form>
@endsection
