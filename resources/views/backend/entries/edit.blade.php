@extends('backend.layout')

@section('content')
    <form
        class="section"
        action="{{ route('backend.entries.update', [$entry->type, $entry]) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @method('PATCH')
        @csrf

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        <a href="{{ route('backend.entries.index', [$entry->type]) }}">
                            @icon('fa-arrow-left-long')
                            <span>{{ $entry->type }}</span>
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
                        <span>@lang('entries.actions.save.label')</span>
                    </button>
                </div>

                @if ($entry->is_cancellable)
                    <div class="level-item">
                        <a
                            class="button"
                            href="{{ route('backend.entries.destroy', [$entry->type, $entry]) }}"
                        >
                            @icon('fa-ban')
                            <span>@lang('entries.actions.cancel.label')</span>
                        </a>
                    </div>
                @endif

                @if (! isset($entry->published_at))
                    <div class="level-item">
                        <button
                            class="button is-success"
                            type="submit"
                            name="publish"
                        >
                            @icon('fa-upload')
                            <span>@lang('entries.actions.publish.label')</span>
                        </button>
                    </div>
                @endif

                <div class="level-item">
                    <a
                        class="button is-danger"
                        href="{{ route('backend.entries.destroy', [$entry->type, $entry]) }}"
                        data-confirm="@lang('general.confirm')"
                    >
                        @icon('fa-trash-can')
                        <span>@lang('entries.actions.destroy.label')</span>
                    </a>
                </div>
            </div>
        </div>

        @include('backend.entries.partials.fields')
    </form>
@endsection
