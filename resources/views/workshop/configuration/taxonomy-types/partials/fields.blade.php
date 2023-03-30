<div class="card">
    <div class="card-content">
        <div class="columns is-multiline">
            <div class="column is-6">
                <div class="field">
                    <label class="label">
                        @lang('taxonomyTypes.attributes.name')
                    </label>

                    <div class="control">
                        <input
                            class="input slug"
                            type="text"
                            name="taxonomy_type[name]"
                            value="{{ $taxonomyType->name }}"
                            maxlength="255"
                            required
                        />
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">
                        @lang('taxonomyTypes.attributes.iconClass')
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            name="taxonomy_type[icon_class]"
                            value="{{ $taxonomyType->icon_class }}"
                            maxlength="100"
                        />
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">
                        @lang('taxonomyTypes.attributes.singularTitle')
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            name="taxonomy_type[singular_title]"
                            value="{{ $taxonomyType->singular_title }}"
                            maxlength="255"
                            required
                        />
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">
                        @lang('taxonomyTypes.attributes.pluralTitle')
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            name="taxonomy_type[plural_title]"
                            value="{{ $taxonomyType->plural_title }}"
                            maxlength="255"
                            required
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
