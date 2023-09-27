<fieldset
    class="filters"
    id="form-filters"
>
    <div class="dropdown is-hoverable is-right">
        <div class="dropdown-trigger">
            <button class="button">
                @icon('fa-filter', 'is-small')
                <span>@lang('filters.label')</span>
                @icon('fa-angle-down', 'is-small')
            </button>
        </div>

        <div class="dropdown-menu">
            <div class="dropdown-content">
                <div class="dropdown-item">
                    <div class="field">
                        <label class="label">
                            @lang('entries.attributes.locale')
                        </label>

                        <div class="control">
                            @foreach (\App\Models\Locale::all() as $localeOption)
                                <label class="checkbox">
                                    <input
                                        name="filters[locale_id][]"
                                        type="checkbox"
                                        value="{{ $localeOption->id }}"
                                        {{ isset($filters['locale_id']) && in_array($localeOption->id,  $filters['locale_id']) ? 'checked' : '' }}
                                    /> {{ $localeOption }}
                                </label><br />
                            @endforeach
                        </div>
                    </div>
                </div>

                <hr class="dropdown-divider">

                <div class="dropdown-item">
                    <div class="columns">
                        <div class="column">
                            <button
                                class="button is-fullwidth is-small is-dark"
                                type="submit"
                            >
                                @icon('fa-check')
                                <span>@lang('filters.apply')</span>
                            </button>
                        </div>

                        <div class="column">
                            <button
                                class="button is-fullwidth is-small"
                                type="submit"
                                data-clear="#form-filters"
                            >
                                @icon('fa-times')
                                <span>@lang('filters.clear')</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>
