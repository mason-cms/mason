@extends('backend.configuration.layout')

@section('main')
    <form
        action="{{ route('backend.configuration.setting.update') }}"
        method="POST"
    >
        @method('PATCH')
        @csrf

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        @lang('settings.title')
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
                        <span>@lang('settings.actions.save.label')</span>
                    </button>
                </div>
            </div>
        </div>

        <hr />

        <div class="card">
            <div class="card-content">
                @if (isset($settings) && $settings->count() > 0)
                    @foreach ($settings as $setting)
                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">
                                    {{ $setting->title }}
                                </label>
                            </div>

                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        @if ($setting->type === 'file')
                                            <div class="file">
                                                <label class="file-label">
                                                    <input
                                                        class="file-input"
                                                        type="file"
                                                        name="settings[{{ $setting->name }}]"
                                                    />

                                                    <span class="file-cta">
                                                        <span class="file-icon">@i('fa-upload')</span>
                                                        <span class="file-label">@lang('settings.fields.file.cta')</span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </form>
@endsection
