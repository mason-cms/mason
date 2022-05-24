<fieldset class="paginator" id="entry-paginator">
    <div class="dropdown is-hoverable is-right">
        <div class="dropdown-trigger">
            <button class="button">
                <span>{{ __('pagination.per_page', ['count' => $perPage]) }}</span>
                <span class="icon is-small"><i class="fa-light fa-angle-down"></i></span>
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
                            >
                        </div>
                    </div>
                </div>

                <div class="dropdown-divider"></div>

                <div class="dropdown-item">
                    <button class="button is-fullwidth is-small is-dark" type="submit">
                        <span class="icon"><i class="fa-light fa-check"></i></span>
                        <span>{{ __('pagination.apply') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</fieldset>
