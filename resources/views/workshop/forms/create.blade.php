<x-modal
    id="create-form-modal"
>
    <form
        class="modal-card"
        action="{{ route('workshop.forms.store') }}"
        method="POST"
    >
        @csrf

        <header class="modal-card-head">
            <h3 class="title is-3 modal-card-title">
                @lang('forms.actions.create.label')
            </h3>
        </header>

        <section class="modal-card-body">
            <div class="field">
                <label
                    class="label"
                    for="form-title"
                >
                    @lang('forms.attributes.title')
                </label>

                <div class="control">
                    <input
                        id="form-title"
                        class="input"
                        name="form[title]"
                        type="text"
                        value="{!! $form->title !!}"
                        maxlength="255"
                    />
                </div>
            </div>

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
    </form>
</x-modal>
