@extends('workshop.configuration.layout')

@section('main')
    <form
        action="{{ route('workshop.configuration.setting.update') }}"
        method="POST"
        enctype="multipart/form-data"
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
                        class="button save is-success"
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
                                        @if ($setting->type === 'text')
                                            <input
                                                class="input"
                                                type="text"
                                                name="settings[{{ $setting->name }}]"
                                                value="{!! $setting->value !!}"
                                            />
                                        @elseif ($setting->type === 'email')
                                            <input
                                                class="input"
                                                type="email"
                                                name="settings[{{ $setting->name }}]"
                                                value="{!! $setting->value !!}"
                                            />
                                        @elseif ($setting->type === 'tel')
                                            <input
                                                class="input"
                                                type="tel"
                                                name="settings[{{ $setting->name }}]"
                                                value="{!! $setting->value !!}"
                                            />
                                        @elseif ($setting->type === 'url')
                                            <input
                                                class="input"
                                                type="url"
                                                name="settings[{{ $setting->name }}]"
                                                value="{!! $setting->value !!}"
                                            />
                                        @elseif ($setting->type === 'textarea')
                                            <textarea
                                                class="textarea"
                                                name="settings[{{ $setting->name }}]"
                                                rows="3"
                                            >{!! $setting->value !!}</textarea>
                                        @elseif ($setting->type === 'file')
                                            @isset($setting->value)
                                                <figure class="image block file-preview">
                                                    <img
                                                        src="{{ storageUrl($setting->value) }}"
                                                        loading="lazy"
                                                        alt=""
                                                        style="width: auto; height: auto; max-width: 600px; max-height: 140px;"
                                                    />
                                                </figure>
                                            @endisset

                                            <div class="file is-fullwidth {{ isset($setting->value) ? 'has-name' : '' }}">
                                                @isset($setting->value)
                                                    <input
                                                        type="hidden"
                                                        name="settings[{{ $setting->name }}]"
                                                        value="{{ $setting->value }}"
                                                    />
                                                @endisset

                                                <label class="file-label">
                                                    <input
                                                        class="file-input"
                                                        type="file"
                                                        name="settings[{{ $setting->name }}]"
                                                    />

                                                    <div class="file-cta">
                                                        <span class="file-icon">@i('fa-upload')</span>
                                                        <span class="file-label">@lang('settings.fields.file.cta')</span>
                                                    </div>

                                                    @isset($setting->value)
                                                        <div class="file-name">{{ $setting->value }}</div>

                                                        <div class="control">
                                                            <a class="button is-danger file-clear">
                                                                @icon('fa-trash-can')
                                                                <span>{{ __("Delete") }}</span>
                                                            </a>
                                                        </div>
                                                    @endisset
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
