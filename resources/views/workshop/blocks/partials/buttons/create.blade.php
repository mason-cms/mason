<a
    class="button is-success"
    href="{{ route('workshop.blocks.create', [
        'location' => $location ?? null,
        'locale_id' => $localeId ?? null,
    ]) }}"
>
    @icon('fa-plus')
    <span>@lang('blocks.actions.create.label')</span>
</a>
