<div
    id="form-field-{{ $field->getKey() }}"
    class="box form-field {{ $field->created_at->diffInSeconds() < 5 ? 'is-new' : '' }}"
>
    <input
        type="hidden"
        name="form[fields][]"
        value="{{ $field->getKey() }}"
    />

    <div class="level">
        <div class="level-left">
            <div class="level-item">
                <h4 class="title is-4">
                    {{ $field->label }}
                </h4>
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
                            href="{{ route('workshop.forms.fields.edit', [$field->form, $field]) }}"
                            title="@lang('forms.fields.actions.edit.label')"
                            rel="open-modal"
                        >
                            @icon('fa-pencil')
                        </a>
                    </div>

                    <div class="control">
                        <a
                            class="button is-white destroy-form-field"
                            href="{{ route('workshop.forms.fields.destroy', [$field->form, $field]) }}"
                            title="@lang('forms.fields.actions.destroy.label')"
                        >
                            @icon('fa-trash-can')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
