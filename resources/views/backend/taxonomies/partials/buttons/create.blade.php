<a
    class="button is-success"
    href="{{ route('backend.taxonomies.create', [$taxonomyType]) }}"
>
    @icon('fa-plus')
    <span>@lang('taxonomies.actions.create.label', ['taxonomyType' => $taxonomyType->singular_title])</span>
</a>
