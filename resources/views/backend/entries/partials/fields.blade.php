<div class="columns">
    <div class="column is-9">
        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <div class="control">
                        <input
                            class="input is-large"
                            name="entry[title]"
                            type="text"
                            value="{!! $entry->title !!}"
                            maxlength="255"
                        >
                    </div>
                </div>

                <div class="field has-addons">
                    <div class="control">
                        <button class="button is-static is-small">
                            {{ __('entries.attributes.name') }}
                        </button>
                    </div>

                    <div class="control is-expanded">
                        <input
                            class="input is-small slug"
                            name="entry[name]"
                            type="text"
                            value="{!! $entry->name !!}"
                            maxlength="255"
                        >
                    </div>

                    <div class="control">
                        <a class="button is-small" href="{{ $entry->url }}" target="_blank">
                            <span class="icon"><i class="fa-light fa-arrow-up-right-from-square"></i></span>
                        </a>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <textarea
                            class="textarea"
                            name="entry[content]"
                            rows="20"
                        >{!! $entry->content !!}</textarea>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="column is-3">
        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <label class="label">
                        {{ __('entries.attributes.published_at') }}
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            name="entry[published_at]"
                            type="datetime-local"
                            value="{{ htmlInputDatetime($entry->published_at) }}"
                        >
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <label class="label">
                        {{ __('entries.attributes.locale') }}
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="entry[locale_id]" autocomplete="off">
                                @foreach(\App\Models\Locale::all() as $localeOption)
                                    <option
                                        value="{{ $localeOption->id }}"
                                        {{ isset($entry->locale) && $entry->locale->is($localeOption) ? 'selected' : '' }}
                                    >{{ $localeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <label class="label">
                        {{ __('entries.attributes.author') }}
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="entry[author_id]" autocomplete="off">
                                @foreach(\App\Models\User::all() as $authorOption)
                                    <option
                                        value="{{ $authorOption->id }}"
                                        {{ isset($entry->author) && $entry->author->is($authorOption) ? 'selected' : '' }}
                                    >{{ $authorOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <label class="label">
                        {{ __('entries.attributes.cover') }}
                    </label>

                    <div class="control">
                        @isset($entry->cover)
                            <figure class="image block">
                                <img src="{{ $entry->cover->url }}">
                            </figure>
                        @endisset

                        <div class="file is-small">
                            <label class="file-label">
                                <input
                                    class="file-input"
                                    type="file"
                                    name="entry[cover_file]"
                                >

                                <span class="file-cta">
                                    <span class="file-icon"><i class="fa-light fa-upload"></i></span>

                                    <span class="file-label">
                                        {{ __('general.file.cta.label') }}
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="card block">
            <div class="card-content">
                <input
                    name="entry[taxonomies]"
                    type="hidden"
                    value=""
                >

                @foreach(\App\Models\TaxonomyType::all() as $taxonomyType)
                    @if ($taxonomyType->taxonomies->count() > 0)
                        <div class="field">
                            <label class="label">
                                {{ $taxonomyType }}
                            </label>

                            <div class="control">
                                @foreach($taxonomyType->taxonomies as $taxonomy)
                                    <label class="checkbox">
                                        <input
                                            type="checkbox"
                                            name="entry[taxonomies][]"
                                            value="{{ $taxonomy->id }}"
                                            {{ $entry->taxonomies->contains($taxonomy) ? 'checked' : '' }}
                                        > {{ $taxonomy }}
                                    </label><br />
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </fieldset>
    </div>
</div>
