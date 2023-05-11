@extends('workshop.configuration.layout')

@section('main')
    <form
        action="{{ route('workshop.configuration.redirection.index') }}"
        method="GET"
    >
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        @lang('redirections.title')
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
                    @include('workshop.configuration.redirections.partials.buttons.create')
                </div>
            </div>
        </div>

        <hr />

        @if ($redirections->count() > 0)
            <div class="card">
                <div class="card-content">
                    @include('workshop.configuration.redirections.partials.table')
                </div>
            </div>

            <hr />

            {{ $redirections->appends(request()->input())->links('workshop.partials.pagination') }}
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    @lang('redirections.noRecords')
                </p>

                <p class="block">
                    @include('workshop.configuration.redirections.partials.buttons.create')
                </p>
            </div>
        @endif
    </form>
@endsection
