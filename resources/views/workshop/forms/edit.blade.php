@extends('workshop.layout')

@section('content')
    <form
        class="section"
        action="{{ route('workshop.forms.update', [$form]) }}"
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
                            href="{{ route('workshop.forms.index', [
                                'locale_id' => $form->locale_id,
                            ]) }}"
                        >
                            @icon('fa-arrow-left-long')
                            <span>@lang('forms.plural')</span>
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
                        <span>@lang('forms.actions.save.label')</span>
                    </button>
                </div>

                <div class="level-item">
                    <a
                        class="button is-danger"
                        href="{{ route('workshop.forms.destroy', [$form]) }}"
                        data-confirm="@lang('general.confirm')"
                    >
                        @icon('fa-trash-can')
                        <span>@lang('forms.actions.destroy.label')</span>
                    </a>
                </div>
            </div>
        </div>

        @include('workshop.forms.partials.fields')
    </form>
@endsection
