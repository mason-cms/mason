@extends('backend.layout')

@section('content')
    <form
        class="section"
        action="{{ route('backend.blocks.update', [$block]) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @method('PATCH')
        @csrf

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        <a
                            href="{{ route('backend.blocks.index', [
                                'location' => $block->location,
                                'locale_id' => $block->locale_id,
                            ]) }}"
                        >
                            @icon('fa-arrow-left-long')
                            <span>@lang('blocks.plural')</span>
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
                        <span>@lang('blocks.actions.save.label')</span>
                    </button>
                </div>

                <div class="level-item">
                    <a
                        class="button is-danger"
                        href="{{ route('backend.blocks.destroy', [$block]) }}"
                        data-confirm="@lang('general.confirm')"
                    >
                        @icon('fa-trash-can')
                        <span>@lang('blocks.actions.destroy.label')</span>
                    </a>
                </div>
            </div>
        </div>

        @include('backend.blocks.partials.fields')
    </form>
@endsection
