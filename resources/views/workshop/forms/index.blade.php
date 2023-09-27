@extends('workshop.layout')

@section('content')
    <section class="section">
        <form
            action="{{ route('workshop.forms.index') }}"
            method="GET"
        >
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h1 class="title is-1">
                            <a href="{{ route('workshop.forms.index') }}">
                                @icon(\App\Models\Form::ICON)
                                <span>@lang('forms.title')</span>
                            </a>
                        </h1>
                    </div>
                </div>

                <div class="level-right">
                    <div class="level-item">
                        @include('workshop.partials.search')
                    </div>

                    <div class="level-item">
                        @include('workshop.forms.partials.filters')
                    </div>

                    <div class="level-item">
                        @include('workshop.partials.paginator')
                    </div>

                    <div class="level-item">
                        <a
                            class="button is-success"
                            href="{{ route('workshop.forms.create') }}"
                            rel="open-modal"
                        >
                            @icon('fa-plus')
                            <span>@lang('forms.actions.create.label')</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <hr />

        @if (isset($forms) && $forms->count() > 0)
            <div class="columns is-multiline is-card-grid">
                @foreach ($forms as $form)
                    <div class="column is-4 is-3-desktop">
                        @include('workshop.forms.partials.card')
                    </div>
                @endforeach
            </div>
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    @lang('forms.noRecords')
                </p>

                <p class="block">
                    <a
                        class="button is-success"
                        href="{{ route('workshop.forms.create') }}"
                        rel="open-modal"
                    >
                        @icon('fa-plus')
                        <span>@lang('forms.actions.create.label')</span>
                    </a>
                </p>
            </div>
        @endif
    </section>
@endsection
