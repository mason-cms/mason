@extends('workshop.layout')

@section('content')
    <form
        class="section"
        action="{{ route('workshop.taxonomies.index', [$taxonomyType]) }}"
        method="GET"
    >
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <div>
                        <h1 class="title is-1">
                            <a href="{{ route('workshop.taxonomies.index', [$taxonomyType]) }}">
                                @isset($taxonomyType)
                                    @icon($taxonomyType->icon_class)
                                @endisset

                                <span>{{ $taxonomyType }}</span>
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
                    @include('workshop.partials.search')
                </div>

                <div class="level-item">
                    @include('workshop.taxonomies.partials.filters')
                </div>

                <div class="level-item">
                    @include('workshop.partials.paginator')
                </div>

                <div class="level-item">
                    @include('workshop.taxonomies.partials.buttons.create', ['taxonomyType' => $taxonomyType])
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
                                        @lang('taxonomies.attributes.title')
                                    </th>

                                    <th>
                                        @lang('taxonomies.attributes.name')
                                    </th>

                                    <th>
                                        @lang('taxonomies.attributes.locale')
                                    </th>

                                    <th>
                                        @lang('entries.plural')
                                    </th>

                                    <th class="is-narrow"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($taxonomies as $taxonomy)
                                    @include('workshop.taxonomies.partials.row', ['depth' => 0])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{ $taxonomies->appends(request()->input())->links('workshop.partials.pagination') }}
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    @lang('taxonomies.noRecords', ['taxonomyType' => strtolower($taxonomyType->plural_title)])
                </p>

                <p class="block">
                    @include('workshop.taxonomies.partials.buttons.create', ['taxonomyType' => $taxonomyType])
                </p>
            </div>
        @endif
    </form>
@endsection
