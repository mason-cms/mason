<div class="columns">
    <div class="column is-3">
        <fieldset
            class="card block"
        >
            <div class="card-content">
                <div class="field">
                    <label class="label" for="menu-location">
                        {{ __('menus.attributes.location') }}
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select
                                id="menu-location"
                                name="menu[location]"
                                autocomplete="off"
                            >
                                <option></option>
                                @foreach($menuLocations as $menuLocation)
                                    <option
                                        value="{{ $menuLocation->name }}"
                                        {{ isset($menu->location) && $menu->location === $menuLocation->name ? 'selected' : '' }}
                                    >{{ $menuLocation->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="menu-locale">
                        {{ __('menus.attributes.locale') }}
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select
                                id="menu-locale"
                                name="menu[locale_id]"
                                autocomplete="off"
                            >
                                @foreach(\App\Models\Locale::all() as $localeOption)
                                    <option
                                        value="{{ $localeOption->id }}"
                                        {{ isset($menu->locale) && $menu->locale->is($localeOption) ? 'selected' : '' }}
                                    >{{ $localeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="column is-9">
        <fieldset class="menu-items">
            <ul>
                @foreach($menu->items()->top()->get() as $item)
                    <li>
                        @include('backend.menus.partials.item')
                    </li>
                @endforeach
            </ul>
        </fieldset>

        <a
            class="button is-primary"
            href="{{ route('backend.menus.items.create', [$menu]) }}"
        >
            <span class="icon"><i class="fa-light fa-plus"></i></span>
            <span>{{ __('menus.items.actions.create.label') }}</span>
        </a>
    </div>
</div>
