<div class="columns">
    <div class="column is-9">
        <div class="card">
            <div class="card-content">
                <div class="field">
                    <label class="label">
                        @lang('locales.attributes.name')
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            name="locale[name]"
                            value="{{ $locale->name }}"
                            maxlength="5"
                            required
                        />
                    </div>
                </div>

                <div class="field">
                    <label class="label">
                        @lang('locales.attributes.title')
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            name="locale[title]"
                            value="{{ $locale->title }}"
                            maxlength="50"
                            required
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="column is-3">
        <div class="card">
            <div class="card-content">
                <div class="field">
                    <div class="control">
                        <input
                            type="hidden"
                            name="locale[is_default]"
                            value="0"
                        />

                        <label class="checkbox">
                            <input
                                type="checkbox"
                                name="locale[is_default]"
                                value="1"
                                {{ $locale->is_default ? 'checked' : '' }}
                            /> @lang('locales.attributes.is_default')
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
