@extends('layouts.backend')

@section('content')
    <form
        class="section"
        action="{{ route('backend.taxonomies.index', [$taxonomyType]) }}"
        method="GET"
    >
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <div>
                        <h1 class="title is-1">
                            <a href="{{ route('backend.taxonomies.index', [$taxonomyType]) }}">
                                {{ $taxonomyType }}
                            </a>
                        </h1>

                        <div class="pagination-count has-text-small">
                            {{ trans_choice('taxonomies.pagination', $taxonomies->count() , ['total' => $total]) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    @include('backend.partials.search')
                </div>

                <div class="level-item">
                    @include('backend.taxonomies.partials.filters')
                </div>

                <div class="level-item">
                    @include('backend.partials.paginator')
                </div>

                <div class="level-item">
                    @include('backend.taxonomies.partials.buttons.create', ['taxonomyType' => $taxonomyType])
                </div>
            </div>
        </div>

        <hr />

        @if ($taxonomies->count() > 0)
            <div class="card block">
                <div class="card-content">
                    <div class="table-container">
                        <table class="table is-fullwidth">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('taxonomies.attributes.title') }}
                                    </th>

                                    <th>
                                        {{ __('taxonomies.attributes.name') }}
                                    </th>

                                    <th>
                                        {{ __('taxonomies.attributes.locale') }}
                                    </th>

                                    <th>
                                        {{ __('entries.plural') }}
                                    </th>

                                    <th class="is-narrow"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($taxonomies as $taxonomy)
                                    @include('backend.taxonomies.partials.row', ['depth' => 0])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{ $taxonomies->appends(request()->input())->links('backend.partials.pagination') }}
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    {{ __('taxonomies.no_records', ['taxonomyType' => strtolower($taxonomyType->plural_title)]) }}
                </p>

                <p class="block">
                    @include('backend.taxonomies.partials.buttons.create', ['taxonomyType' => $taxonomyType])
                </p>
            </div>
        @endif
    </form>
@endsection
