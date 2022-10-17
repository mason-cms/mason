<div class="columns">
    <div class="column is-9">
        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <div class="control">
                        <input
                            id="entry-title"
                            class="input is-large"
                            name="entry[title]"
                            type="text"
                            value="{!! $entry->title !!}"
                            maxlength="255"
                        />
                    </div>
                </div>

                <div class="field has-addons">
                    <div class="control">
                        <button class="button is-static is-small">
                            @lang('entries.attributes.name')
                        </button>
                    </div>

                    <div class="control is-expanded">
                        <input
                            id="entry-name"
                            class="input is-small slug"
                            name="entry[name]"
                            type="text"
                            value="{!! $entry->name !!}"
                            maxlength="255"
                            data-slug-from="#entry-title"
                        >
                    </div>

                    <div class="control">
                        <a
                            class="button is-small"
                            href="{{ $entry->url }}"
                            target="_blank"
                        >
                            @icon('fa-arrow-up-right-from-square')
                        </a>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <div
                            class="code-editor"
                            data-editor-input="#entry-content"
                            style="min-height: 400px;"
                        >{{ $entry->content }}</div>

                        <textarea
                            id="entry-content"
                            class="textarea is-hidden"
                            name="entry[content]"
                            rows="20"
                        >{{ $entry->content }}</textarea>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="column is-3">
        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <label
                        class="label"
                        for="entry-published-at"
                    >
                        @lang('entries.attributes.published_at')
                    </label>

                    <div class="control">
                        <input
                            id="entry-published-at"
                            class="input"
                            name="entry[published_at]"
                            type="datetime-local"
                            value="{{ htmlInputDatetime($entry->published_at) }}"
                        />
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <input
                            type="hidden"
                            name="entry[is_home]"
                            value="0"
                        />

                        <label class="checkbox">
                            <input
                                type="checkbox"
                                name="entry[is_home]"
                                value="1"
                                {{ $entry->is_home ? 'checked' : '' }}
                            /> @lang('entries.attributes.is_home')
                        </label>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <label
                        class="label"
                        for="entry-locale"
                    >
                        @lang('entries.attributes.locale')
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select
                                id="entry-locale"
                                name="entry[locale_id]"
                                autocomplete="off"
                            >
                                @foreach (\App\Models\Locale::all() as $localeOption)
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
                    <label
                        class="label"
                        for="entry-author"
                    >
                        @lang('entries.attributes.author')
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select
                                id="entry-author"
                                name="entry[author_id]"
                                autocomplete="off"
                            >
                                @foreach (\App\Models\User::all() as $authorOption)
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
                    <label
                        class="label"
                        for="entry-cover-file"
                    >
                        @lang('entries.attributes.cover')
                    </label>

                    <div class="control">
                        @isset($entry->cover)
                            <figure class="image block">
                                <img src="{{ $entry->cover->url }}" />
                            </figure>
                        @endisset

                        <div class="file is-small">
                            <label class="file-label">
                                <input
                                    id="entry-cover-file"
                                    class="file-input"
                                    type="file"
                                    name="entry[cover_file]"
                                />

                                <span class="file-cta">
                                    <span class="file-icon">@i('fa-upload')</span>

                                    <span class="file-label">
                                        @lang('general.file.cta.label')
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
                />

                @foreach (\App\Models\TaxonomyType::all() as $taxonomyType)
                    @if ($taxonomyType->taxonomies()->count() > 0)
                        <div class="field">
                            <label class="label">
                                {{ $taxonomyType }}
                            </label>

                            <div class="control">
                                @foreach ($taxonomyType->taxonomies()->topLevel()->get() as $taxonomy)
                                    @include('backend.entries.partials.taxonomy-checkbox')
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </fieldset>
    </div>
</div>
