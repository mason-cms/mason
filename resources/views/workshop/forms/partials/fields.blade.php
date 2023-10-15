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
                        <button
                            class="button is-static is-small"
                        >@lang('forms.attributes.name')</button>
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
                        />
                    </div>
                </div>

                <div class="field">
                    <label
                        class="label"
                        for="form-description"
                    >@lang('forms.attributes.description')</label>

                    <div class="control">
                        <textarea
                            id="form-description"
                            class="textarea"
                            name="form[description]"
                            rows="2"
                        >{!! $form->description !!}</textarea>
                    </div>
                </div>

                <div class="field">
                    <label
                        class="label"
                        for="form-confirmation-message"
                    >@lang('forms.attributes.confirmation_message')</label>

                    <div class="control">
                        <textarea
                            id="form-confirmation-message"
                            class="textarea"
                            name="form[confirmation_message]"
                            rows="2"
                        >{!! $form->confirmation_message !!}</textarea>
                    </div>
                </div>
            </div>
        </fieldset>

        <hr />

        <fieldset class="block">
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h2 class="title is-2">
                            @icon(\App\Models\FormField::ICON)
                            <span>@lang('forms.fields.title')</span>
                        </h2>
                    </div>
                </div>

                <div class="level-right">
                    <div class="level-item">
                        <a
                            class="button is-success"
                            href="{{ route('workshop.forms.addField', [$form]) }}"
                            rel="append"
                            target="#form-fields"
                        >
                            @icon('fa-plus')
                            <span>@lang('forms.actions.addField.label')</span>
                        </a>
                    </div>
                </div>
            </div>

            <div
                id="form-fields"
                class="columns is-multiline ui-sortable"
            >
                @foreach ($form->fields as $field)
                    @include('workshop.forms.partials.field')
                @endforeach
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
                    >@lang('forms.attributes.locale')</label>

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

        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <label
                        class="label"
                        for="form-send-to"
                    >@lang('forms.attributes.send_to')</label>

                    <div class="control">
                        <input
                            id="form-send-to"
                            class="input"
                            name="form[send_to]"
                            type="text"
                            value="{!! $form->send_to !!}"
                            maxlength="255"
                        />
                    </div>
                </div>

                <div class="field">
                    <label
                        class="label"
                        for="form-reply-to"
                    >@lang('forms.attributes.reply_to')</label>

                    <div class="control">
                        <input
                            id="form-reply-to"
                            class="input"
                            name="form[reply_to]"
                            type="text"
                            value="{!! $form->reply_to !!}"
                            maxlength="255"
                            list="form-fields-datalist"
                        />
                    </div>
                </div>

                <div class="field">
                    <label
                        class="label"
                        for="form-cc"
                    >@lang('forms.attributes.cc')</label>

                    <div class="control">
                        <input
                            id="form-cc"
                            class="input"
                            name="form[cc]"
                            type="text"
                            value="{!! $form->cc !!}"
                            maxlength="255"
                            list="form-fields-datalist"
                        />
                    </div>
                </div>

                <div class="field">
                    <label
                        class="label"
                        for="form-bcc"
                    >@lang('forms.attributes.bcc')</label>

                    <div class="control">
                        <input
                            id="form-bcc"
                            class="input"
                            name="form[bcc]"
                            type="text"
                            value="{!! $form->bcc !!}"
                            maxlength="255"
                            list="form-fields-datalist"
                        />
                    </div>
                </div>

                <div class="field">
                    <label
                        class="label"
                        for="form-redirect-to"
                    >@lang('forms.attributes.redirect_to')</label>

                    <div class="control">
                        <input
                            id="form-redirect-to"
                            class="input"
                            name="form[redirect_to]"
                            type="text"
                            value="{!! $form->redirect_to !!}"
                            placeholder="https://"
                            maxlength="255"
                        />
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <label
                        class="label"
                        for="form-grecaptcha-enabled"
                    >@lang('forms.attributes.grecaptcha_enabled')</label>

                    <div class="control">
                        <label class="radio">
                            <input
                                name="form[grecaptcha_enabled]"
                                type="radio"
                                value="1"
                                {{ isset($form->grecaptcha_enabled) && $form->grecaptcha_enabled === true ? 'checked' : '' }}
                            /> @lang('general.yes')
                        </label>

                        <label class="radio">
                            <input
                                name="form[grecaptcha_enabled]"
                                type="radio"
                                value="0"
                                {{ isset($form->grecaptcha_enabled) && $form->grecaptcha_enabled === false ? 'checked' : '' }}
                            /> @lang('general.no')
                        </label>
                    </div>
                </div>

                <div class="field">
                    <label
                        class="label"
                        for="form-grecaptcha-site-key"
                    >@lang('forms.attributes.grecaptcha_site_key')</label>

                    <div class="control">
                        <input
                            id="form-grecaptcha-site-key"
                            class="input"
                            name="form[grecaptcha_site_key]"
                            type="text"
                            value="{!! $form->grecaptcha_site_key !!}"
                            maxlength="255"
                            {{ $form->grecaptcha_enabled ? 'required' : '' }}
                        />
                    </div>
                </div>

                <div class="field">
                    <label
                        class="label"
                        for="form-grecaptcha-secret-key"
                    >@lang('forms.attributes.grecaptcha_secret_key')</label>

                    <div class="control">
                        <input
                            id="form-grecaptcha-secret-key"
                            class="input"
                            name="form[grecaptcha_secret_key]"
                            type="text"
                            value="{!! $form->grecaptcha_secret_key !!}"
                            maxlength="255"
                            {{ $form->grecaptcha_enabled ? 'required' : '' }}
                        />
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<datalist id="form-fields-datalist">
    @foreach ($form->fields as $field)
        <option value="{{ $field->name }}">{{ $field->label }}</option>
    @endforeach
</datalist>
