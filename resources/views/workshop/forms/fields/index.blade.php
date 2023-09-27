@extends('workshop.layout')

@section('content')
    <form
        class="section autosave"
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
                        @icon(\App\Models\FormField::ICON)
                        <span>@lang('forms.fields.title')</span>
                    </h1>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    <a
                        class="button is-success"
                        href="{{ route('workshop.forms.fields.create', [$form]) }}"
                        rel="open-modal"
                    >
                        @icon('fa-plus')
                        <span>@lang('forms.fields.actions.create.label')</span>
                    </a>
                </div>
            </div>
        </div>

        <hr />

        <ul class="ui-sortable">
            @foreach ($fields as $field)
                <li class="block">
                    @include('workshop.forms.fields.partials.item')
                </li>
            @endforeach
        </ul>
    </form>
@endsection
