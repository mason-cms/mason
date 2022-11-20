<div class="card">
    <div class="card-content">
        <div class="columns is-multiline">
            <div class="column is-6">
                <div class="field">
                    <label class="label">
                        @lang('entryTypes.attributes.name')
                    </label>

                    <div class="control">
                        <input
                            class="input slug"
                            type="text"
                            name="entry_type[name]"
                            value="{{ $entryType->name }}"
                            maxlength="255"
                            required
                        />
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">
                        @lang('entryTypes.attributes.iconClass')
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            name="entry_type[icon_class]"
                            value="{{ $entryType->icon_class }}"
                            maxlength="100"
                        />
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">
                        @lang('entryTypes.attributes.singularTitle')
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            name="entry_type[singular_title]"
                            value="{{ $entryType->singular_title }}"
                            maxlength="255"
                            required
                        />
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">
                        @lang('entryTypes.attributes.pluralTitle')
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            name="entry_type[plural_title]"
                            value="{{ $entryType->plural_title }}"
                            maxlength="255"
                            required
                        />
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">
                        @lang('entryTypes.attributes.defaultEditorMode')
                    </label>

                    <div class="control">
                        @foreach (\App\Enums\EditorMode::cases() as $editorMode)
                            <label class="radio">
                                <input
                                    name="entry_type[default_editor_mode]"
                                    type="radio"
                                    value="{{ $editorMode }}"
                                    {{ $entryType->default_editor_mode === $editorMode ? 'checked' : '' }}
                                /> {{ $editorMode }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
