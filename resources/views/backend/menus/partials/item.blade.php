<div class="box menu-item {{ $item->created_at->diffInSeconds() < 5 ? 'is-new' : '' }}">
    <div class="level">
        <div class="level-left">
            @if (isset($item->target) && $item->differs_from_target)
                <div class="level-item">
                    <span
                        class="icon is-large has-text-danger"
                        title="{{ __('menus.items.alerts.differs_from_target') }}"
                    ><i class="fa-light fa-lg fa-triangle-exclamation"></i></span>
                </div>
            @endif
            
            <div class="level-item">
                <div>
                    <h4 class="title is-4">
                        {{ $item }}
                    </h4>

                    <div class="is-size-6">
                        @isset($item->href)
                            <div class="menu-item-href">
                                <a href="{{ $item->href }}" target="_blank">
                                    {{ $item->href }}
                                </a>
                            </div>
                        @else
                            @isset($item->target, $item->target->url)
                                <div class="menu-item-target-url has-text-small">
                                    <a href="{{ $item->target->url }}" target="_blank">
                                        {{ $item->target->url }}
                                    </a>
                                </div>
                            @endisset
                        @endisset
                    </div>
                </div>
            </div>
        </div>

        <div class="level-right">
            <div class="level-item">
                <div class="field has-addons">
                    <div class="control">
                        <a
                            class="button is-white edit-menu-item"
                            href="{{ route('backend.menus.items.edit', [$item->menu, $item]) }}"
                            title="{{ __('menus.actions.edit.label') }}"
                            rel="open-modal"
                        >
                            <span class="icon"><i class="fa-light fa-pencil"></i></span>
                        </a>
                    </div>

                    <div class="control">
                        <a
                            class="button is-white create-sub-menu-item"
                            href="{{ route('backend.menus.items.create', [$item->menu, 'item' => ['parent_id' => $item->id]]) }}"
                            title="{{ __('menus.items.actions.create.label') }}"
                        >
                            <span class="icon"><i class="fa-light fa-plus"></i></span>
                        </a>
                    </div>

                    <div class="control">
                        <a
                            class="button is-white destroy-menu-item"
                            href="{{ route('backend.menus.items.destroy', [$item->menu, $item]) }}"
                            title="{{ __('menus.items.actions.destroy.label') }}"
                        >
                            <span class="icon"><i class="fa-light fa-trash-can"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($item->children->count() > 0)
    <ul>
        @foreach($item->children as $child)
            <li>
                @include('backend.menus.partials.item', ['item' => $child])
            </li>
        @endforeach
    </ul>
@endif

