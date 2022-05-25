<div class="columns">
    <div class="column is-9">
        <div class="card block">
            <div class="card-content">
                <div class="field">
                    <label class="label">
                        {{ __('taxonomies.attributes.title') }}
                    </label>

                    <div class="control">
                        <input
                            id="taxonomy-title"
                            class="input is-large"
                            name="taxonomy[title]"
                            type="text"
                            value="{!! $taxonomy->title !!}"
                            maxlength="255"
                        >
                    </div>
                </div>

                <div class="field">
                    <label class="label">
                        {{ __('taxonomies.attributes.name') }}
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
                        >
                    </div>
                </div>

                <div class="field">
                    <label class="label">
                        {{ __('taxonomies.attributes.description') }}
                    </label>

                    <div class="control">
                        <textarea
                            id="taxonomy-description"
                            class="textarea"
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
                        {{ __('taxonomies.attributes.locale') }}
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select
                                id="taxonomy-locale"
                                name="taxonomy[locale_id]"
                                autocomplete="off"
                            >
                                @foreach(\App\Models\Locale::all() as $localeOption)
                                    <option
                                        value="{{ $localeOption->id }}"
                                        {{ isset($taxonomy->locale) && $taxonomy->locale->is($localeOption) ? 'selected' : '' }}
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
                        {{ __('taxonomies.attributes.parent') }}
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select
                                id="taxonomy-parent"
                                name="taxonomy[parent_id]"
                                autocomplete="off"
                            >
                                <option></option>

                                @foreach($taxonomy->getParentOptions() as $taxonomyOption)
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
                        {{ __('taxonomies.attributes.cover') }}
                    </label>

                    <div class="control">
                        @isset($taxonomy->cover)
                            <figure class="image block">
                                <img src="{{ $taxonomy->cover->url }}">
                            </figure>
                        @endisset

                        <div class="file is-small">
                            <label class="file-label">
                                <input
                                    id="taxonomy-cover-file"
                                    class="file-input"
                                    type="file"
                                    name="taxonomy[cover_file]"
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
    </div>
</div>
