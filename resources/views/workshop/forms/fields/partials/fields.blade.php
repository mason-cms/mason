<div class="field">
    <label
        class="label"
        for="form-field-label"
    >
        @lang('forms.fields.attributes.label')
    </label>

    <div class="control">
        <input
            id="form-field-label"
            class="input"
            name="field[label]"
            type="text"
            value="{!! $field->label !!}"
            maxlength="255"
        />
    </div>
</div>

<div class="field has-addons">
    <div class="control">
        <button class="button is-static is-small">
            @lang('forms.fields.attributes.name')
        </button>
    </div>

    <div class="control is-expanded">
        <input
            id="form-field-name"
            class="input is-small"
            name="field[name]"
            type="text"
            value="{!! $field->name !!}"
            maxlength="255"
        />
    </div>
</div>

<div class="field">
    <label
        class="label"
        for="form-field-type"
    >
        @lang('forms.fields.attributes.type')
    </label>

    <div class="control">
        <div class="select is-fullwidth">
            <select
                id="form-field-type"
                name="field[type]"
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
        for="form-field-description"
    >
        @lang('forms.fields.attributes.description')
    </label>

    <div class="control">
        <textarea
            id="form-field-description"
            class="textarea"
            name="field[description]"
            rows="2"
        >{!! $field->description !!}</textarea>
    </div>
</div>

<div class="field">
    <label
        class="label"
        for="form-field-placeholder"
    >
        @lang('forms.fields.attributes.placeholder')
    </label>

    <div class="control">
        <input
            id="form-field-placeholder"
            class="input"
            name="field[placeholder]"
            type="text"
            value="{!! $field->placeholder !!}"
            maxlength="255"
        />
    </div>
</div>

<div class="field">
    <label
        class="label"
        for="form-field-default-value"
    >
        @lang('forms.fields.attributes.default_value')
    </label>

    <div class="control">
        <textarea
            id="form-field-default-value"
            class="textarea"
            name="field[default_value]"
            rows="1"
        >{!! $field->default_value !!}</textarea>
    </div>
</div>

<div class="field">
    <label
        class="label"
        for="form-field-class"
    >
        @lang('forms.fields.attributes.class')
    </label>

    <div class="control">
        <input
            id="form-field-class"
            class="input"
            name="field[class]"
            type="text"
            value="{!! $field->class !!}"
            maxlength="255"
        />
    </div>
</div>

<div class="field">
    <label class="label">
        @lang('forms.fields.attributes.rules')
    </label>

    <div class="control">
        <input
            id="form-field-rules"
            class="input"
            name="field[rules]"
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
        for="form-field-options"
    >
        @lang('forms.fields.attributes.options')
    </label>

    <div class="control">
        <textarea
            id="form-field-options"
            class="textarea"
            name="field[options]"
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
        for="form-field-columns"
    >
        @lang('forms.fields.attributes.columns')
    </label>

    <div class="control">
        <input
            id="form-field-columns"
            class="input"
            name="field[columns]"
            type="number"
            value="{!! $field->columns !!}"
            min="1"
            max="12"
            step="1"
        />
    </div>
</div>
