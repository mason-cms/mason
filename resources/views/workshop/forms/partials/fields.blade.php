<div class="columns">
    <div class="column is-9">
        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <div class="control">
                        <input
                            id="form-title"
                            class="input is-large"
                            name="form[title]"
                            type="text"
                            value="{!! $form->title !!}"
                            maxlength="255"
                        />
                    </div>
                </div>

                <div class="field has-addons">
                    <div class="control">
                        <button class="button is-static is-small">
                            @lang('forms.attributes.name')
                        </button>
                    </div>

                    <div class="control is-expanded">
                        <input
                            id="form-name"
                            class="input is-small slug"
                            name="form[name]"
                            type="text"
                            value="{!! $form->name !!}"
                            maxlength="255"
                            data-slug-from="#form-title"
                        >
                    </div>
                </div>

                <div class="field">
                    <label
                        class="label"
                        for="form-description"
                    >
                        @lang('forms.attributes.description')
                    </label>

                    <div class="control">
                        <textarea
                            id="form-description"
                            class="textarea"
                            name="form[description]"
                            rows="4"
                        >{!! $form->description !!}</textarea>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="column is-3">
        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <label
                        class="label"
                        for="form-locale"
                    >
                        @lang('forms.attributes.locale')
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select
                                id="form-locale"
                                name="form[locale_id]"
                                autocomplete="off"
                            >
                                @foreach (\App\Models\Locale::all() as $localeOption)
                                    <option
                                        value="{{ $localeOption->getKey() }}"
                                        {{ isset($form->locale) && $form->locale->is($localeOption) ? 'selected' : '' }}
                                    >{{ $localeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
