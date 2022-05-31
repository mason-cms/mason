<div class="field">
    <label class="label" for="item-target">
        {{ __('menus.items.attributes.target') }}
    </label>

    <div class="control">
        <div class="select is-fullwidth">
            <select
                id="item-target"
                name="item[target]"
                autocomplete="off"
            >
                <option value="">{{ __('menus.items.attributes.href') }}</option>

                @foreach($item->target_options as $group => $groupTargetOptions)
                    <optgroup label="{{ $group }}">
                        @foreach($groupTargetOptions as $targetOption)
                            <option
                                value="{{ get_class($targetOption) }}:{{ $targetOption->id }}"
                                data-url="{{ $targetOption->url ?? '' }}"
                                {{ isset($item->target) && $item->target->is($targetOption) ? 'selected' : '' }}
                            >{{ $targetOption }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="field">
    <label class="label" for="item-href">
        {{ __('menus.items.attributes.href') }}
    </label>

    <div class="control">
        <input
            id="item-href"
            class="input"
            name="item[href]"
            type="url"
            maxlength="255"
            value="{{ $item->href }}"
            placeholder="{{ config('app.url') }}"
        >
    </div>
</div>

<div class="field">
    <label class="label" for="item-title">
        {{ __('menus.items.attributes.title') }}
    </label>

    <div class="control">
        <input
            id="item-title"
            class="input"
            name="item[title]"
            type="text"
            maxlength="255"
            value="{{ $item->title }}"
        >
    </div>
</div>

<div class="field">
    <label class="label" for="item-parent">
        {{ __('menus.items.attributes.parent') }}
    </label>

    <div class="control">
        <div class="select is-fullwidth">
            <select
                id="item-parent"
                name="item[parent_id]"
                autocomplete="off"
            >
                <option></option>

                @foreach($item->parent_options as $parentOption)
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
    <a class="is-size-6" href="#item-advanced-options" rel="toggle">
        <span class="icon"><i class="fa-light fa-sliders-up"></i></span>
        <span>{{ __("Advanced options") }}</span>
    </a>
</div>

<div id="item-advanced-options" class="block is-hidden">
    <div class="field">
        <label
            class="label is-small"
            for="item-metadata-class"
        >
            Class
        </label>

        <div class="control">
            <input
                id="item-metadata-class"
                class="input is-small"
                name="item[metadata][class]"
                type="text"
                value="{{ $item->metadata['class'] ?? '' }}"
            >
        </div>
    </div>

    <div class="field">
        <label
            class="label is-small"
            for="item-metadata-rel"
        >
            Rel
        </label>

        <div class="control">
            <input
                id="item-metadata-rel"
                class="input is-small"
                name="item[metadata][rel]"
                type="text"
                value="{{ $item->metadata['rel'] ?? '' }}"
            >
        </div>
    </div>

    <div class="field">
        <label
            class="label is-small"
            for="item-metadata-target"
        >
            Target
        </label>

        <div class="control">
            <input
                id="item-metadata-target"
                class="input is-small"
                name="item[metadata][target]"
                type="text"
                value="{{ $item->metadata['target'] ?? '' }}"
            >
        </div>
    </div>
</div>
