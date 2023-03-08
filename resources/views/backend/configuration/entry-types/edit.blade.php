@extends('backend.configuration.layout')

@section('main')
    <form
        action="{{ route('backend.configuration.entry-type.update', [$entryType]) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @method('PATCH')
        @csrf

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        <a href="{{ route('backend.configuration.entry-type.index') }}">
                            @icon('fa-arrow-left-long')
                            <span>@lang('entryTypes.title')</span>
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
                        <span>@lang('entryTypes.actions.save.label')</span>
                    </button>
                </div>
            </div>
        </div>

        @include('backend.configuration.entry-types.partials.fields')
    </form>
@endsection
