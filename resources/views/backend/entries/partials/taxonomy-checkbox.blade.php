@php
    $depth ??= 0;
@endphp

<label class="checkbox">
    {!! str_repeat('&mdash;', $depth) !!}

    <input
        type="checkbox"
        name="entry[taxonomies][]"
        value="{{ $taxonomy->id }}"
        {{ $entry->taxonomies->contains($taxonomy) ? 'checked' : '' }}
    >

    {{ $taxonomy }}
</label><br />

@foreach ($taxonomy->children as $child)
    @include('backend.entries.partials.taxonomy-checkbox', ['taxonomy' => $child, 'depth' => $depth + 1])
@endforeach
