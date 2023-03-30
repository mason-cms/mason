<fieldset class="search" id="entry-search">
    <div class="field has-addons">
        <div class="control has-icons-left">
            @icon('fa-magnifying-glass', 'is-left')

            <input
                class="input"
                type="search"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="@lang('general.search')"
            />
        </div>

        <div class="control">
            <button
                class="button"
                type="submit"
            >
                @icon('fa-check')
            </button>
        </div>
    </div>
</fieldset>
