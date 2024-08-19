<div class="columns">
    <div class="column is-9">
        <fieldset class="card block">
            <div class="card-content">
                <div class="field">
                    <div class="control">
                        <input
                            id="block-title"
                            class="input is-large"
                            name="block[title]"
                            type="text"
                            value="{!! $block->title !!}"
                            maxlength="255"
                        />
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <div
                            id="block-content"
                            class="textarea {{ isset($block->editor_mode) ? $block->editor_mode->cssClass() : '' }}"
                            data-input="#block-content-input"
                            data-media-upload="{{ route('workshop.medium.store', ['medium' => ['parent_id' => $block->getKey(), 'parent_type' => get_class($block)]]) }}"
                            data-base64="{!! base64_encode($block->content) !!}"
                        ></div>

                        <input
                            id="block-content-input"
                            type="hidden"
                            name="block[base64_content]"
                        />
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        @foreach (\App\Enums\EditorMode::cases() as $editorMode)
                            <label class="radio">
                                <input
                                    name="block[editor_mode]"
                                    type="radio"
                                    value="{{ $editorMode }}"
                                    {{ $block->editor_mode === $editorMode ? 'checked' : '' }}
                                /> {{ $editorMode }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </fieldset>
    </div>

    <div class="column is-3">
        <fieldset class="card block">
            <div class="card-content">
                @isset($blockLocations)
                    <div class="field">
                        <label
                            class="label"
                            for="block-location"
                        >
                            @lang('blocks.attributes.location')
                        </label>

                        <div class="control">
                            <div class="select is-fullwidth">
                                <select
                                    id="block-location"
                                    name="block[location]"
                                    autocomplete="off"
                                >
                                    @foreach ($blockLocations as $blockLocationOption)
                                        <option
                                            value="{{ $blockLocationOption->name }}"
                                            {{ isset($block->location) && $block->location === $blockLocationOption->name ? 'selected' : '' }}
                                        >{{ $blockLocationOption->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endisset

                <div class="field">
                    <label
                        class="label"
                        for="block-locale"
                    >
                        @lang('blocks.attributes.locale')
                    </label>

                    <div class="control">
                        <div class="select is-fullwidth">
                            <select
                                id="block-locale"
                                name="block[locale_id]"
                                autocomplete="off"
                            >
                                <option value="">@lang('general.all')</option>

                                @foreach (\App\Models\Locale::all() as $localeOption)
                                    <option
                                        value="{{ $localeOption->getKey() }}"
                                        {{ isset($block->locale) && $block->locale->is($localeOption) ? 'selected' : '' }}
                                    >{{ $localeOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
