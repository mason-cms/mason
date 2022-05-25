<a
    class="button is-success"
    href="{{ route('backend.entries.create', [$entryType]) }}"
>
    <span class="icon"><i class="fa-light fa-plus"></i></span>
    <span>{{ __('entries.actions.create.label', ['entryType' => $entryType->singular_title]) }}</span>
</a>
