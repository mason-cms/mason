<fieldset class="search" id="entry-search">
    <div class="field has-addons">
        <div class="control has-icons-left">
            <span class="icon is-left"><i class="fa-light fa-magnifying-glass"></i></span>

            <input
                class="input"
                type="search"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="{{ __('general.search') }}"
            >
        </div>

        <div class="control">
            <button class="button" type="submit">
                <span class="icon"><i class="fa-light fa-check"></i></span>
            </button>
        </div>
    </div>
</fieldset>
