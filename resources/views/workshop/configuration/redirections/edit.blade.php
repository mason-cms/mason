@extends('workshop.configuration.layout')

@section('main')
    <form
        action="{{ route('workshop.configuration.redirection.update', [$redirection]) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @method('PATCH')
        @csrf

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        <a href="{{ route('workshop.configuration.redirection.index') }}">
                            @icon('fa-arrow-left-long')
                            <span>@lang('redirections.title')</span>
                        </a>
                    </h1>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    <button
                        class="button save is-success"
                        type="submit"
                    >
                        @icon('fa-floppy-disk')
                        <span>@lang('redirections.actions.save.label')</span>
                    </button>
                </div>
            </div>
        </div>

        @include('workshop.configuration.redirections.partials.fields')
    </form>
@endsection
