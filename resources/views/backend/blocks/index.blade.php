@extends('backend.layout')

@section('content')
    <section class="section">
        <form
            class="autosave"
            action="{{ route('backend.blocks.index') }}"
            method="GET"
        >
            <div class="level">
                <div class="level-left">
                    <div class="level-item">
                        <h1 class="title is-1">
                            <a href="{{ route('backend.blocks.index') }}">
                                @icon(\App\Models\Block::ICON)
                                <span>@lang('blocks.title')</span>
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
                                        <option value="">@lang('blocks.attributes.location')</option>

                                        @foreach ($blockLocations as $blockLocation)
                                            <option
                                                value="{{ $blockLocation->name }}"
                                                {{ $request->has('location') && $blockLocation->name == $request->get('location') ? 'selected' : '' }}
                                            >{{ $blockLocation->title }}</option>
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
                                        <option value="">@lang('blocks.attributes.locale')</option>

                                        @foreach ($locales as $locale)
                                            <option
                                                value="{{ $locale->id }}"
                                                {{ $request->has('locale_id') && $locale->id == $request->get('locale_id') ? 'selected' : '' }}
                                            >{{ $locale }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @icon('fa-language', 'is-left')
                            </div>
                        </div>
                    </div>

                    <div class="level-item">
                        @include('backend.blocks.partials.buttons.create', [
                            'location' => $request->get('location'),
                            'localeId' => $request->get('locale_id'),
                        ])
                    </div>
                </div>
            </div>
        </form>

        <hr />

        @if (isset($blocks) && $blocks->count() > 0)
            <div class="columns is-multiline same-height-cards">
                @foreach ($blocks as $block)
                    <div class="column is-4 is-3-desktop">
                        @include('backend.blocks.partials.card')
                    </div>
                @endforeach
            </div>
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    @lang('blocks.noRecords')
                </p>

                <p class="block">
                    @include('backend.blocks.partials.buttons.create', [
                        'location' => $request->get('location'),
                        'localeId' => $request->get('locale_id'),
                    ])
                </p>
            </div>
        @endif
    </section>
@endsection
