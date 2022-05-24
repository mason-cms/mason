@extends('layouts.backend')

@section('content')
    <section class="section">
        <div class="columns">
            <div class="column">
                <div class="level">
                    <div class="level-left">
                        <div class="level-item">
                            <h1 class="title is-1">
                                {{ $entryType }}
                            </h1>
                        </div>
                    </div>

                    <div class="level-right">
                        <form
                            class="level-item search"
                            action="{{ route('backend.entries.index', [$entryType]) }}"
                            method="GET"
                        >
                            @csrf

                            <div class="field">
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
                            </div>
                        </form>

                        <form
                            class="level-item filters"
                            action="{{ route('backend.entries.index', [$entryType]) }}"
                            method="GET"
                        >
                            @csrf

                            <div class="dropdown is-hoverable is-right">
                                <div class="dropdown-trigger">
                                    <button class="button">
                                        <span>{{ __('filters.label') }}</span>
                                        <span class="icon is-small"><i class="fa-light fa-angle-down"></i></span>
                                    </button>
                                </div>

                                <div class="dropdown-menu">
                                    <div class="dropdown-content">
                                        <div class="dropdown-item">
                                            <div class="field">
                                                <label class="label">
                                                    {{ __('entries.attributes.locale') }}
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

                                        <hr class="dropdown-divider">

                                        <div class="dropdown-item">
                                            <div class="field">
                                                <label class="label">
                                                    {{ __('entries.attributes.author') }}
                                                </label>

                                                <div class="control">
                                                    @foreach(\App\Models\User::all() as $authorOption)
                                                        <label class="checkbox">
                                                            <input
                                                                name="filters[author_id][]"
                                                                type="checkbox"
                                                                value="{{ $authorOption->id }}"
                                                                {{ isset($filters['author_id']) && in_array($authorOption->id,  $filters['author_id']) ? 'checked' : '' }}
                                                            >
                                                            {{ $authorOption }}
                                                        </label><br />
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="dropdown-divider">

                                        <div class="dropdown-item">
                                            <div class="buttons">
                                                <button class="button is-small is-dark" type="submit">
                                                    <span class="icon"><i class="fa-light fa-filter"></i></span>
                                                    <span>{{ __('filters.apply') }}</span>
                                                </button>

                                                <button class="button is-small" type="clear">
                                                    <span class="icon"><i class="fa-light fa-times"></i></span>
                                                    <span>{{ __('filters.clear') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="level-item">
                            <a class="button is-success" href="{{ route('backend.entries.create', [$entryType]) }}">
                                <span class="icon"><i class="fa-light fa-plus"></i></span>
                                <span>{{ __('entries.actions.create.label') }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="columns is-multiline">
                    @foreach($entries as $entry)
                        <div class="column is-3">
                            @include('backend.partials.entries.card')
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
