@extends('workshop.layout')

@section('content')
    <form
        class="section"
        action="{{ route('workshop.users.index') }}"
        method="GET"
    >
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <div>
                        <h1 class="title is-1">
                            <a href="{{ route('workshop.users.index') }}">
                                @icon(\App\Models\User::ICON)
                                <span>@lang('users.title')</span>
                            </a>
                        </h1>

                        <div class="pagination-count has-text-small">
                            {{ trans_choice('users.pagination', $users->count() , ['total' => $total]) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="level-right">
                <div class="level-item">
                    @include('workshop.partials.search')
                </div>

                <div class="level-item">
                    @include('workshop.users.partials.filters')
                </div>

                <div class="level-item">
                    @include('workshop.partials.paginator')
                </div>

                <div class="level-item">
                    @include('workshop.users.partials.buttons.create')
                </div>
            </div>
        </div>

        <hr />

        @if ($users->count() > 0)
            <div class="columns is-multiline">
                @foreach ($users as $user)
                    <div class="column is-4-tablet is-3-desktop">
                        @include('workshop.users.partials.user')
                    </div>
                @endforeach
            </div>

            {{ $users->appends(request()->input())->links('workshop.partials.pagination') }}
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    @lang('users.noRecords')
                </p>

                <p class="block">
                    @include('workshop.users.partials.buttons.create')
                </p>
            </div>
        @endif
    </form>
@endsection
