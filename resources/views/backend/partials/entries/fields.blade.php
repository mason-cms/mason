<div class="columns">
    <div class="column is-9">
        <div class="card">
            <div class="card-content">
                <div class="field">
                    <div class="control">
                        <input
                            class="input is-large"
                            name="entry[title]"
                            type="text"
                            value="{!! $entry->title !!}"
                            maxlength="255"
                            required
                        >
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                <textarea
                    class="textarea"
                    name="entry[body]"
                    rows="20"
                >{!! $entry->body !!}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="column is-3">
        <div class="card">
            <div class="card-content">
                <div class="field">
                    <label class="label">
                        {{ __('entries.attributes.locale') }}
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="entry[locale_id]" autocomplete="off">
                                @foreach(\App\Models\Locale::all() as $localeOption)
                                    <option
                                        value="{{ $localeOption->id }}"
                                        {{ isset($entry->locale) && $entry->locale->is($localeOption) ? 'selected' : '' }}
                                    >{{ $localeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
