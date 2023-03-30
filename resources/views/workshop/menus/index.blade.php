@extends('workshop.layout')

@section('content')
    <section class="section">
        <form
            class="autosave"
            action="{{ route('workshop.menus.index') }}"
            method="GET"
        >
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h1 class="title is-1">
                            <a href="{{ route('workshop.menus.index') }}">
                                @icon(\App\Models\Menu::ICON)
                                <span>@lang('menus.title')</span>
                            </a>
                        </h1>
                    </div>
                </div>

                <div class="level-right">
                    <div class="level-item">
                        <div class="field">
                            <div class="control has-icons-left">
                                <div class="select">
                                    <select
                                        name="location"
                                        autocomplete="off"
                                    >
                                        <option value="">@lang('menus.attributes.location')</option>

                                        @foreach ($menuLocations as $menuLocation)
                                            <option
                                                value="{{ $menuLocation->name }}"
                                                {{ isset($request->location) && $menuLocation->name === $request->location ? 'selected' : '' }}
                                            >{{ $menuLocation->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @icon('fa-square', 'is-left')
                            </div>
                        </div>
                    </div>

                    <div class="level-item">
                        <div class="field">
                            <div class="control has-icons-left">
                                <div class="select">
                                    <select
                                        name="locale_id"
                                        autocomplete="off"
                                    >
                                        <option value="">@lang('menus.attributes.locale')</option>

                                        @foreach ($locales as $locale)
                                            <option
                                                value="{{ $locale->id }}"
                                                {{ isset($request->locale_id) && $locale->id == $request->locale_id ? 'selected' : '' }}
                                            >{{ $locale }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @icon('fa-language', 'is-left')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <hr />

        @isset($menu)
            @if ($menu->root_items->count() > 0)
                <form
                    class="autosave"
                    action="{{ route('workshop.menus.update', [$menu]) }}"
                    method="POST"
                >
                    @method('PATCH')
                    @csrf

                    <fieldset class="menu-items">
                        <ul class="ui-sortable">
                            @foreach ($menu->root_items as $item)
                                <li>
                                    @include('workshop.menus.partials.item')
                                </li>
                            @endforeach
                        </ul>
                    </fieldset>
                </form>

                @include('workshop.menus.items.partials.buttons.create')
            @else
                <section class="section has-text-centered">
                    @include('workshop.menus.items.partials.buttons.create')
                </section>
            @endif
        @endisset
    </section>
@endsection
