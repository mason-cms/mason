<div class="columns">
    <div class="column is-9">
        <div class="card block">
            <div class="card-content">
                <div class="field">
                    <label class="label">
                        @lang('taxonomies.attributes.title')
                    </label>

                    <div class="control">
                        <input
                            id="taxonomy-title"
                            class="input is-large"
                            name="taxonomy[title]"
                            type="text"
                            value="{!! $taxonomy->title !!}"
                            maxlength="255"
                        />
                    </div>
                </div>

                <div class="field">
                    <label class="label">
                        @lang('taxonomies.attributes.name')
                    </label>

                    <div class="control">
                        <input
                            id="taxonomy-name"
                            class="input slug"
                            name="taxonomy[name]"
                            type="text"
                            value="{!! $taxonomy->name !!}"
                            maxlength="255"
                            data-slug-from="#taxonomy-title"
                        />
                    </div>
                </div>

                <div class="field">
                    <label class="label">
                        @lang('taxonomies.attributes.description')
                    </label>

                    <div class="control">
                        <textarea
                            id="taxonomy-description"
                            class="textarea is-code"
                            name="taxonomy[description]"
                            rows="20"
                        >{!! $taxonomy->description !!}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="column is-3">
        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <label class="label">
                        @lang('taxonomies.attributes.locale')
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select
                                id="taxonomy-locale"
                                name="taxonomy[locale_id]"
                                autocomplete="off"
                            >
                                @foreach (\App\Models\Locale::all() as $localeOption)
                                    <option
                                        value="{{ $localeOption->id }}"
                                        {{ isset($taxonomy->locale) && $taxonomy->locale->is($localeOption) ? 'selected' : '' }}
                                    >{{ $localeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @isset($taxonomy->locale)
                    @if ($taxonomy->locale->is_default)
                        <div class="field">
                            <label class="label">
                                @lang('taxonomies.attributes.translations')
                            </label>

                            <ul>
                                @foreach ($taxonomy->translations as $translation)
                                    <li>
                                        <a href="{{ route('workshop.taxonimies.edit', [$taxonomy->type, $taxonomy]) }}">
                                            {{ $taxonomy }} ({{ $taxonomy->locale }})
                                            @icon('fa-pencil')
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="field">
                            <label
                                class="label"
                                for="taxonomy-original"
                            >
                                @lang('taxonomies.attributes.original')
                            </label>

                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select
                                        id="taxonomy-original"
                                        name="taxonomy[original_id]"
                                        autocomplete="off"
                                        onchange="$('#taxonomy-edit-original').hide();"
                                    >
                                        <option></option>

                                        @foreach (\App\Models\Taxonomy::originals()->get() as $originalTaxonomyOption)
                                            <option
                                                value="{{ $originalTaxonomyOption->getKey() }}"
                                                {{ isset($taxonomy->original_instance) && $taxonomy->original_instance->is($originalTaxonomyOption) ? 'selected' : '' }}
                                            >{{ $originalTaxonomyOption }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @isset($taxonomy->original_instance)
                                <p
                                    id="taxonomy-edit-original"
                                    class="help"
                                >
                                    <a href="{{ route('workshop.taxonomies.edit', [$taxonomy->original_instance->type, $taxonomy->original_instance]) }}">
                                        @icon('fa-pencil')
                                        @lang('taxonomies.actions.editOriginal.label')
                                    </a>
                                </p>
                            @endisset
                        </div>
                    @endif
                @endisset
            </div>
        </fieldset>

        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <label class="label">
                        @lang('taxonomies.attributes.parent')
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select
                                id="taxonomy-parent"
                                name="taxonomy[parent_id]"
                                autocomplete="off"
                            >
                                <option></option>

                                @foreach ($taxonomy->getParentOptions() as $taxonomyOption)
                                    <option
                                        value="{{ $taxonomyOption->id }}"
                                        {{ isset($taxonomy->parent) && $taxonomy->parent->is($taxonomyOption) ? 'selected' : '' }}
                                    >{{ $taxonomyOption }}</option>
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
                        @lang('taxonomies.attributes.cover')
                    </label>

                    <div class="control">
                        @isset($taxonomy->cover)
                            <figure class="image block">
                                <img src="{{ $taxonomy->cover->url }}" />
                            </figure>
                        @endisset

                        <div class="file is-small">
                            <label class="file-label">
                                <input
                                    id="taxonomy-cover-file"
                                    class="file-input"
                                    type="file"
                                    name="taxonomy[cover_file]"
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
    </div>
</div>
