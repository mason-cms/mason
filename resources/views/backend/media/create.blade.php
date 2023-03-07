@extends('backend.layout')

@section('content')
    <form
        class="section"
        action="{{ route('backend.medium.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-1">
                        <a href="{{ route('backend.medium.index') }}">
                            @icon('fa-arrow-left-long')
                            <span>@lang('media.title')</span>
                        </a>
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
                        <span>@lang('media.actions.save.label')</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <section class="section is-medium">
                    <div class="field is-spaced">
                        <div class="control">
                            <div class="file is-centered">
                                <label class="file-label">
                                    <input
                                        id="media-file"
                                        class="file-input"
                                        type="file"
                                        name="files[]"
                                        multiple
                                    />

                                    <span class="file-cta">
                                        <span class="file-icon">@i('fa-upload')</span>

                                        <span class="file-label">
                                            @lang('general.file.cta.label')
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
@endsection
