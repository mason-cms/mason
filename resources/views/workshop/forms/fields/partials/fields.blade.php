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

<div class="field">
    <label
        class="label"
        for="form-field-name"
    >
        @lang('forms.fields.attributes.name')
    </label>

    <div class="control">
        <input
            id="form-field-name"
            class="input"
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
