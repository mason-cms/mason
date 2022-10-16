<a
    class="button is-success"
    href="{{ route('backend.entries.create', [$entryType]) }}"
>
    @icon('fa-plus')
    <span>@lang('entries.actions.create.label', ['entryType' => $entryType->singular_title])</span>
</a>
