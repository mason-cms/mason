@extends('layouts.backend')

@section('content')
    <form
        class="section"
        action="{{ route('backend.entries.update', [$entryType, $entry]) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @method('PATCH')
        @csrf
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        <a href="{{ route('backend.entries.index', [$entryType]) }}">
                            <span class="icon"><i class="fa-light fa-arrow-left-long"></i></span>
                            <span>{{ $entryType }}</span>
                        </a>
                    </h1>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    <button class="button is-dark" type="submit">
                        <span class="icon"><i class="fa-light fa-floppy-disk"></i></span>
                        <span>{{ __('entries.actions.save.label') }}</span>
                    </button>
                </div>

                @if (! isset($entry->title))
                    <div class="level-item">
                        <a class="button" href="{{ route('backend.entries.destroy', [$entry->type, $entry]) }}">
                            <span class="icon"><i class="fa-light fa-ban"></i></span>
                            <span>{{ __('entries.actions.cancel.label') }}</span>
                        </a>
                    </div>
                @endif

                @if (! isset($entry->published_at))
                    <div class="level-item">
                        <button class="button is-success" type="submit" name="publish">
                            <span class="icon"><i class="fa-light fa-upload"></i></span>
                            <span>{{ __('entries.actions.publish.label') }}</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        @include('backend.partials.entries.fields')
    </form>
@endsection
