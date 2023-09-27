<div
    class="modal {{ $class ?? '' }}"
    id="{{ $id ?? '' }}"
>
    <div class="modal-background"></div>

    <div class="modal-content">
        {!! $slot !!}
    </div>

    @if ($close ?? true)
        <button
            class="modal-close is-large"
            aria-label="close"
            title="{{ __('base.close') }}"
        ></button>
    @endif
</div>
