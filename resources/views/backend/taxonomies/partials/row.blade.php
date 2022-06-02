<tr>
    <td>
        {!! str_repeat('&mdash;', $depth) !!}

        <a href="{{ route('backend.taxonomies.edit', [$taxonomy->type, $taxonomy]) }}">
            {{ $taxonomy->title }}
        </a>
    </td>

    <td>
        {{ $taxonomy->name }}
    </td>

    <td>
        {{ $taxonomy->locale }}
    </td>

    <td>
        {{ $taxonomy->entries()->count() }}
    </td>

    <td>
        <div class="field has-addons">
            <div class="control">
                <a
                    class="button is-small"
                    href="{{ route('backend.taxonomies.edit', [$taxonomy->type, $taxonomy]) }}"
                >
                    <span class="icon"><i class="fa-light fa-pencil"></i></span>
                </a>
            </div>

            <div class="control">
                <a
                    class="button is-small"
                    href="{{ route('backend.taxonomies.destroy', [$taxonomy->type, $taxonomy]) }}"
                    data-confirm="{{ __('general.confirm') }}"
                >
                    <span class="icon has-text-danger"><i class="fa-light fa-trash-can"></i></span>
                </a>
            </div>
        </div>
    </td>
</tr>

@foreach($taxonomy->children as $taxonomy)
    @include('backend.taxonomies.partials.row', ['depth' => $depth + 1])
@endforeach
