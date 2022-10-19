@extends('backend.configuration.layout')

@section('main')
    <form
        action="{{ route('backend.configuration.update') }}"
        method="POST"
    >
        @method('PATCH')
        @csrf

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        @lang('configuration.general.title')
                    </h1>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    <button
                        class="button is-dark"
                        type="submit"
                    >
                        @icon('fa-floppy-disk')
                        <span>@lang('configuration.general.actions.save.label')</span>
                    </button>
                </div>
            </div>
        </div>

        <hr />

        <div class="card">
            <div class="card-content">
                @foreach ($fields as $field)
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label">
                                {{ $field['label'] }}
                            </label>
                        </div>

                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    @if ($field['type'] === 'text')
                                        <input
                                            class="input"
                                            type="text"
                                            name="configuration[{{ $field['name'] }}]"
                                            maxlength="255"
                                            value="{!! $field['value'] !!}"
                                            {{ $field['required'] ? 'required' : '' }}
                                        />
                                    @elseif ($field['type'] === 'boolean')
                                        <label class="radio">
                                            <input
                                                type="radio"
                                                name="configuration[{{ $field['name'] }}]"
                                                value="1"
                                                {{ $field['value'] === true ? 'checked' : '' }}
                                            /> @lang('general.yes')
                                        </label>

                                        <label class="radio">
                                            <input
                                                type="radio"
                                                name="configuration[{{ $field['name'] }}]"
                                                value="0"
                                                {{ $field['value'] === false ? 'checked' : '' }}
                                            /> @lang('general.no')
                                        </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>
@endsection
