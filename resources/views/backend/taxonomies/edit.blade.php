@extends('backend.layout')

@section('content')
    <form
        class="section"
        action="{{ route('backend.taxonomies.update', [$taxonomy->type, $taxonomy]) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @method('PATCH')
        @csrf

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        <a href="{{ route('backend.taxonomies.index', [$taxonomy->type]) }}">
                            @icon('fa-arrow-left-long')
                            <span>{{ $taxonomy->type }}</span>
                        </a>
                    </h1>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    <button
                        class="button is-success"
                        type="submit"
                    >
                        @icon('fa-floppy-disk')
                        <span>@lang('taxonomies.actions.save.label')</span>
                    </button>
                </div>

                @if ($taxonomy->is_cancellable)
                    <div class="level-item">
                        <a
                            class="button"
                            href="{{ route('backend.taxonomies.destroy', [$taxonomy->type, $taxonomy]) }}"
                        >
                            @icon('fa-ban')
                            <span>@lang('taxonomies.actions.cancel.label')</span>
                        </a>
                    </div>
                @endif

                <div class="level-item">
                    <a
                        class="button is-danger"
                        href="{{ route('backend.taxonomies.destroy', [$taxonomy->type, $taxonomy]) }}"
                        data-confirm="@lang('general.confirm')"
                    >
                        @icon('fa-trash-can')
                        <span>@lang('taxonomies.actions.destroy.label')</span>
                    </a>
                </div>
            </div>
        </div>

        @include('backend.taxonomies.partials.fields')
    </form>
@endsection
