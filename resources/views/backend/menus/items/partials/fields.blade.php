<div class="field">
    <label
        class="label"
        for="item-target"
    >
        @lang('menus.items.attributes.target')
    </label>

    <div class="control">
        <div class="select is-fullwidth">
            <select
                id="item-target"
                name="item[target]"
                autocomplete="off"
            >
                <option value="">@lang('menus.items.attributes.href')</option>

                @foreach ($item->target_options as $group => $groupTargetOptions)
                    <optgroup label="{{ $group }}">
                        @foreach ($groupTargetOptions as $targetOption)
                            <option
                                value="{{ get_class($targetOption) }}:{{ $targetOption->getKey() }}"
                                data-url="{{ $targetOption->url ?? '' }}"
                                {{ isset($item->target) && $item->target->is($targetOption) ? 'selected' : '' }}
                            >{{ $targetOption->title ?? "{$targetOption}" }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="field">
    <label
        class="label"
        for="item-href"
    >
        @lang('menus.items.attributes.href')
    </label>

    <div class="control">
        <input
            id="item-href"
            class="input"
            name="item[href]"
            type="text"
            maxlength="255"
            value="{{ $item->href }}"
            placeholder="{{ config('app.url') }}"
        />
    </div>

    @if (isset($item->target, $item->target->url) && $item->target->url !== $item->href)
        <p class="help is-danger">
            @lang('menus.items.alerts.href_differs_from_target', ['target_url' => $item->target->url])
        </p>
    @endif
</div>

<div class="field">
    <label class="label" for="item-title">
        @lang('menus.items.attributes.title')
    </label>

    <div class="control">
        <input
            id="item-title"
            class="input"
            name="item[title]"
            type="text"
            maxlength="255"
            value="{{ $item->title }}"
        />
    </div>

    @if (isset($item->target, $item->target->title) && $item->target->title !== $item->title)
        <p class="help is-danger">
            @lang('menus.items.alerts.title_differs_from_target', ['target_title' => $item->target->title])
        </p>
    @endif
</div>

<div class="field">
    <label
        class="label"
        for="item-parent"
    >
        @lang('menus.items.attributes.parent')
    </label>

    <div class="control">
        <div class="select is-fullwidth">
            <select
                id="item-parent"
                name="item[parent_id]"
                autocomplete="off"
            >
                <option></option>

                @foreach ($item->parent_options as $parentOption)
                    <option
                        value="{{ $parentOption->id }}"
                        {{ isset($item->parent) && $item->parent->is($parentOption) ? 'selected' : '' }}
                    >{{ $parentOption }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="block">
    <a
        class="is-size-6"
        href="#item-advanced-options"
        rel="toggle"
    >
        @icon('fa-sliders-up')
        <span>@lang('menu.advancedOptions.title')</span>
    </a>
</div>

<div
    id="item-advanced-options"
    class="block is-hidden"
>
    <div class="field">
        <label
            class="label"
            for="item-metadata-class"
        >
            @lang('menus.items.meta.class')
        </label>

        <div class="control">
            <input
                id="item-metadata-class"
                class="input"
                name="item[metadata][class]"
                type="text"
                value="{{ $item->metadata['class'] ?? '' }}"
            />
        </div>
    </div>

    <div class="field">
        <label
            class="label"
            for="item-metadata-rel"
        >
            @lang('menus.items.meta.rel')
        </label>

        <div class="control">
            <input
                id="item-metadata-rel"
                class="input"
                name="item[metadata][rel]"
                type="text"
                value="{{ $item->metadata['rel'] ?? '' }}"
            />
        </div>
    </div>

    <div class="field">
        <label
            class="label"
            for="item-metadata-target"
        >
            @lang('menus.items.meta.target')
        </label>

        <div class="control">
            <input
                id="item-metadata-target"
                class="input"
                name="item[metadata][target]"
                type="text"
                value="{{ $item->metadata['target'] ?? '' }}"
            />
        </div>
    </div>
</div>
