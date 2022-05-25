<fieldset class="filters" id="taxonomy-filters">
    <div class="dropdown is-hoverable is-right">
        <div class="dropdown-trigger">
            <button class="button">
                <span class="icon is-small"><i class="fa-light fa-filter"></i></span>
                <span>{{ __('filters.label') }}</span>
                <span class="icon is-small"><i class="fa-light fa-angle-down"></i></span>
            </button>
        </div>

        <div class="dropdown-menu">
            <div class="dropdown-content">
                <div class="dropdown-item">
                    <div class="field">
                        <label class="label">
                            {{ __('taxonomies.attributes.locale') }}
                        </label>

                        <div class="control">
                            @foreach(\App\Models\Locale::all() as $localeOption)
                                <label class="checkbox">
                                    <input
                                        name="filters[locale_id][]"
                                        type="checkbox"
                                        value="{{ $localeOption->id }}"
                                        {{ isset($filters['locale_id']) && in_array($localeOption->id,  $filters['locale_id']) ? 'checked' : '' }}
                                    >
                                    {{ $localeOption }}
                                </label><br />
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="dropdown-item">
                    <div class="columns">
                        <div class="column">
                            <button class="button is-fullwidth is-small is-dark" type="submit">
                                <span class="icon"><i class="fa-light fa-check"></i></span>
                                <span>{{ __('filters.apply') }}</span>
                            </button>
                        </div>

                        <div class="column">
                            <button class="button is-fullwidth is-small" type="submit" data-clear="#taxonomy-filters">
                                <span class="icon"><i class="fa-light fa-times"></i></span>
                                <span>{{ __('filters.clear') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
