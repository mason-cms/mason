<a
    class="button is-success"
    href="{{ route('backend.taxonomies.create', [$taxonomyType]) }}"
>
    <span class="icon"><i class="fa-light fa-plus"></i></span>
    <span>{{ __('taxonomies.actions.create.label', ['taxonomyType' => $taxonomyType->singular_title]) }}</span>
</a>
