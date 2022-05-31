@extends('layouts.backend')

@section('content')
    <form
        class="section"
        action="{{ route('backend.menus.index') }}"
        method="GET"
    >
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <div>
                        <h1 class="title is-1">
                            <a href="{{ route('backend.menus.index') }}">
                                {{ __('menus.title') }}
                            </a>
                        </h1>

                        <div class="pagination-count">
                            {{ trans_choice('menus.pagination', $menus->count() , ['total' => $total]) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    @include('backend.menus.partials.filters')
                </div>

                <div class="level-item">
                    @include('backend.menus.partials.buttons.create')
                </div>
            </div>
        </div>

        <hr />

        @if ($menus->count() > 0)
            <div class="card block">
                <div class="card-content">
                    <div class="table-container">
                        <table class="table is-fullwidth">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('menus.attributes.location') }}
                                    </th>

                                    <th>
                                        {{ __('menus.attributes.locale') }}
                                    </th>

                                    <th class="is-narrow"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($menus as $menu)
                                    <tr>
                                        <td>
                                            {{ $menu->location_title }}
                                        </td>

                                        <td>
                                            {{ $menu->locale }}
                                        </td>

                                        <td>
                                            <div class="field is-grouped">
                                                <div class="control">
                                                    <a
                                                        class="button is-small"
                                                        href="{{ route('backend.menus.edit', [$menu]) }}"
                                                    >
                                                        <span class="icon"><i class="fa-light fa-pencil"></i></span>
                                                    </a>
                                                </div>

                                                <div class="control">
                                                    <a
                                                        class="button is-small is-danger"
                                                        href="{{ route('backend.menus.destroy', [$menu]) }}"
                                                        data-confirm="{{ __('general.confirm') }}"
                                                    >
                                                        <span class="icon"><i class="fa-light fa-trash-can"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{ $menus->appends(request()->input())->links('backend.partials.pagination') }}
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    {{ __('menus.no_records') }}
                </p>

                <p class="block">
                    @include('backend.menus.partials.buttons.create')
                </p>
            </div>
        @endif
    </form>
@endsection
