@extends('layouts.backend')

@section('content')
    <form
        id="edit-menu-form"
        class="section autosave"
        action="{{ route('backend.menus.update', [$menu]) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @method('PATCH')
        @csrf

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        <a href="{{ route('backend.menus.index') }}">
                            <span class="icon"><i class="fa-light fa-arrow-left-long"></i></span>
                            <span>{{ __('menus.title') }}</span>
                        </a>
                    </h1>
                </div>
            </div>

            <div class="level-right">
                @if ($menu->is_cancellable)
                    <div class="level-item">
                        <a class="button" href="{{ route('backend.menus.destroy', [$menu]) }}">
                            <span class="icon"><i class="fa-light fa-ban"></i></span>
                            <span>{{ __('menus.actions.cancel.label') }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        @include('backend.menus.partials.fields')
    </form>
@endsection
