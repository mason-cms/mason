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

            <div class="column is-4">
                <div class="field">
                    <label class="label">
                        @lang('entryTypes.attributes.defaultOrderColumn')
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="entry_type[default_order_column]">
                                <option></option>

                                @foreach (\App\Models\EntryType::ORDER_COLUMNS as $column)
                                    <option
                                        value="{{ $column }}"
                                        {{ isset($entryType->default_order_column) && $entryType->default_order_column === $column ? 'selected' : '' }}
                                    >{{ $column }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-2">
                <div class="field">
                    <label class="label">
                        @lang('entryTypes.attributes.defaultOrderDirection')
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="entry_type[default_order_direction]">
                                <option></option>

                                @foreach (\App\Models\EntryType::ORDER_DIRECTIONS as $direction)
                                    <option
                                        value="{{ $direction }}"
                                        {{ isset($entryType->default_order_direction) && $entryType->default_order_direction === $direction ? 'selected' : '' }}
                                    >{{ $direction }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
