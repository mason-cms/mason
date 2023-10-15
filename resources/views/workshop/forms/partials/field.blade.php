<div class="column is-{{ $field->columns }}">
    <fieldset
        id="form-field-{{ $field->getKey() }}"
        class="form-field {{ $field->created_at->diffInSeconds() < 5 ? 'is-new' : '' }}"
    >
        <div class="box is-marginless">
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h4
                            class="title is-4"
                        >{{ $field->label }}</h4>
                    </div>

                    <div class="level-item">
                        <div class="tags has-addons">
                            @isset($field->name)
                                <span class="tag is-dark">{{ $field->name }}</span>
                            @endisset

                            @isset($field->type)
                                <span class="tag is-info">{{ $field->type }}</span>
                            @endisset
                        </div>
                    </div>
                </div>

                <div class="level-right">
                    <div class="level-item">
                        <div class="field has-addons">
                            <div class="control">
                                <a
                                    class="button is-white edit-form-field"
                                    href="#edit-form-field-{{ $field->getKey() }}-modal"
                                    title="@lang('forms.fields.actions.edit.label')"
                                    rel="open-modal"
                                >@icon('fa-pencil')</a>
                            </div>

                            <div class="control">
                                <a
                                    class="button is-white destroy-form-field"
                                    href="#form-field-{{ $field->getKey() }}"
                                    title="@lang('forms.fields.actions.destroy.label')"
                                    rel="remove"
                                >@icon('fa-trash-can')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-modal id="edit-form-field-{{ $field->getKey() }}-modal">
            <div class="modal-card">
                <header class="modal-card-head">
                    <h3
                        class="title is-3 modal-card-title"
                    >@lang('forms.fields.actions.edit.title')</h3>
                </header>

                <section class="modal-card-body">
                    <div class="field">
                        <label
                            class="label"
                            for="form-field-{{ $field->getKey() }}-label"
                        >@lang('forms.fields.attributes.label')</label>

                        <div class="control">
                            <input
                                id="form-field-{{ $field->getKey() }}-label"
                                class="input"
                                name="form[fields][{{ $field->getKey() }}][label]"
                                type="text"
                                value="{!! $field->label !!}"
                                maxlength="255"
                            />
                        </div>
                    </div>

                    <div class="field has-addons">
                        <div class="control">
                            <button
                                class="button is-static is-small"
                            >@lang('forms.fields.attributes.name')</button>
                        </div>

                        <div class="control is-expanded">
                            <input
                                id="form-field-{{ $field->getKey() }}-name"
                                class="input is-small"
                                name="form[fields][{{ $field->getKey() }}][name]"
                                type="text"
                                value="{!! $field->name !!}"
                                maxlength="255"
                            />
                        </div>
                    </div>

                    <div class="field">
                        <label
                            class="label"
                            for="form-field-{{ $field->getKey() }}-type"
                        >@lang('forms.fields.attributes.type')</label>

                        <div class="control">
                            <div class="select is-fullwidth">
                                <select
                                    id="form-field-{{ $field->getKey() }}-type"
                                    name="form[fields][{{ $field->getKey() }}][type]"
                                    autocomplete="off"
                                >
                                    @foreach (\App\Enums\FormFieldType::cases() as $fieldTypeOption)
                                        <option
                                            value="{{ $fieldTypeOption->value }}"
                                            {{ isset($field->type) && $field->type === $fieldTypeOption ? 'selected' : '' }}
                                        >{{ $fieldTypeOption->label() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label
                            class="label"
                            for="form-field-{{ $field->getKey() }}-description"
                        >@lang('forms.fields.attributes.description')</label>

                        <div class="control">
                        <textarea
                            id="form-field-{{ $field->getKey() }}-description"
                            class="textarea"
                            name="form[fields][{{ $field->getKey() }}][description]"
                            rows="2"
                        >{!! $field->description !!}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <label
                            class="label"
                            for="form-field-{{ $field->getKey() }}-placeholder"
                        >@lang('forms.fields.attributes.placeholder')</label>

                        <div class="control">
                            <input
                                id="form-field-{{ $field->getKey() }}-placeholder"
                                class="input"
                                name="form[fields][{{ $field->getKey() }}][placeholder]"
                                type="text"
                                value="{!! $field->placeholder !!}"
                                maxlength="255"
                            />
                        </div>
                    </div>

                    <div class="field">
                        <label
                            class="label"
                            for="form-field-{{ $field->getKey() }}-default-value"
                        >@lang('forms.fields.attributes.default_value')</label>

                        <div class="control">
                        <textarea
                            id="form-field-{{ $field->getKey() }}-default-value"
                            class="textarea"
                            name="form[fields][{{ $field->getKey() }}][default_value]"
                            rows="1"
                        >{!! $field->default_value !!}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <label
                            class="label"
                            for="form-field-{{ $field->getKey() }}-class"
                        >@lang('forms.fields.attributes.class')</label>

                        <div class="control">
                            <input
                                id="form-field-{{ $field->getKey() }}-class"
                                class="input"
                                name="form[fields][{{ $field->getKey() }}][class]"
                                type="text"
                                value="{!! $field->class !!}"
                                maxlength="255"
                            />
                        </div>
                    </div>

                    <div class="field">
                        <label
                            class="label"
                            for="form-field-{{ $field->getKey() }}-rules"
                        >@lang('forms.fields.attributes.rules')</label>

                        <div class="control">
                            <input
                                id="form-field-{{ $field->getKey() }}-rules"
                                class="input"
                                name="form[fields][{{ $field->getKey() }}][rules]"
                                type="text"
                                value="{!! $field->rules !!}"
                                maxlength="255"
                            />
                        </div>

                        <p class="help">
                            @lang('forms.fields.help.rules')
                        </p>
                    </div>

                    <div class="field">
                        <label
                            class="label"
                            for="form-field-{{ $field->getKey() }}-options"
                        >@lang('forms.fields.attributes.options')</label>

                        <div class="control">
                        <textarea
                            id="form-field-{{ $field->getKey() }}-options"
                            class="textarea"
                            name="form[fields][{{ $field->getKey() }}][options]"
                            rows="5"
                        >{!! $field->options !!}</textarea>
                        </div>

                        <p class="help">
                            @lang('forms.fields.help.options')
                        </p>
                    </div>

                    <div class="field">
                        <label
                            class="label"
                            for="form-field-{{ $field->getKey() }}-columns"
                        >@lang('forms.fields.attributes.columns')</label>

                        <div class="control">
                            <input
                                id="form-field-{{ $field->getKey() }}-columns"
                                class="input"
                                name="form[fields][{{ $field->getKey() }}][columns]"
                                type="number"
                                value="{!! $field->columns !!}"
                                min="1"
                                max="12"
                                step="1"
                            />
                        </div>
                    </div>

                </section>

                <footer class="modal-card-foot">
                    <button
                        class="button save is-success"
                        type="submit"
                    >
                        @icon('fa-floppy-disk')
                        <span>@lang('forms.fields.actions.save.label')</span>
                    </button>
                </footer>
            </div>
        </x-modal>
    </fieldset>
</div>
