<tr>
    <td>
        {!! str_repeat('&mdash;', $depth) !!}

        <a href="{{ route('workshop.taxonomies.edit', [$taxonomy->type, $taxonomy]) }}">
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
                    href="{{ route('workshop.taxonomies.edit', [$taxonomy->type, $taxonomy]) }}"
                >
                    @icon('fa-pencil')
                </a>
            </div>

            <div class="control">
                <a
                    class="button is-small"
                    href="{{ route('workshop.taxonomies.destroy', [$taxonomy->type, $taxonomy]) }}"
                    data-confirm="@lang('general.confirm')"
                >
                    @icon('fa-trash-can', 'has-text-danger')
                </a>
            </div>
        </div>
    </td>
</tr>

@foreach ($taxonomy->children as $taxonomy)
    @include('workshop.taxonomies.partials.row', ['depth' => $depth + 1])
@endforeach
