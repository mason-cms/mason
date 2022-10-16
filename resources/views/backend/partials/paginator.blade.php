<fieldset
    id="entry-paginator"
    class="paginator"
>
    <div class="dropdown is-hoverable is-right">
        <div class="dropdown-trigger">
            <button class="button">
                <span>@lang('pagination.per_page', ['count' => $perPage])</span>
                @icon('fa-angle-down', 'is-small')
            </button>
        </div>

        <div class="dropdown-menu">
            <div class="dropdown-content">
                <div class="dropdown-item">
                    <div class="field">
                        <div class="control">
                            <input
                                class="input"
                                name="per_page"
                                type="number"
                                min="1"
                                value="{{ $perPage }}"
                            />
                        </div>
                    </div>
                </div>

                <div class="dropdown-divider"></div>

                <div class="dropdown-item">
                    <button
                        class="button is-fullwidth is-small is-dark"
                        type="submit"
                    >
                        @icon('fa-check')
                        <span>@lang('pagination.apply')</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</fieldset>
