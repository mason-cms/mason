@extends('layouts.backend')

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
                            <span class="icon"><i class="fa-light fa-arrow-left-long"></i></span>
                            <span>{{ $taxonomy->type }}</span>
                        </a>
                    </h1>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    <button class="button is-dark" type="submit">
                        <span class="icon"><i class="fa-light fa-floppy-disk"></i></span>
                        <span>{{ __('taxonomies.actions.save.label') }}</span>
                    </button>
                </div>

                @if (! isset($taxonomy->title))
                    <div class="level-item">
                        <a class="button" href="{{ route('backend.taxonomies.destroy', [$taxonomy->type, $taxonomy]) }}">
                            <span class="icon"><i class="fa-light fa-ban"></i></span>
                            <span>{{ __('taxonomies.actions.cancel.label') }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        @include('backend.taxonomies.partials.fields')
    </form>
@endsection
