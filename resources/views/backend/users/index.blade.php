@extends('backend.layout')

@section('content')
    <form
        class="section"
        action="{{ route('backend.users.index') }}"
        method="GET"
    >
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <div>
                        <h1 class="title is-1">
                            <a href="{{ route('backend.users.index') }}">
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
                    @include('backend.partials.search')
                </div>

                <div class="level-item">
                    @include('backend.users.partials.filters')
                </div>

                <div class="level-item">
                    @include('backend.partials.paginator')
                </div>

                <div class="level-item">
                    @include('backend.users.partials.buttons.create')
                </div>
            </div>
        </div>

        <hr />

        @if ($users->count() > 0)
            <div class="columns is-multiline">
                @foreach ($users as $user)
                    <div class="column is-4-tablet is-3-desktop">
                        <div class="user user-{{ $user->getKey() }} mb-4 has-text-centered">
                            @isset($user->gravatar_url)
                                <figure class="user-gravatar image is-128x128 is-centered block">
                                    <a href="{{ route('backend.users.edit', [$user]) }}">
                                        <img
                                            class="is-rounded"
                                            src="{{ $user->gravatar_url }}?s=128"
                                            width="128"
                                            height="128"
                                        />
                                    </a>
                                </figure>
                            @endisset

                            <h2 class="title is-2">
                                {{ $user->name }}
                            </h2>

                            <div class="subtitle">
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </div>

                            <div class="field has-addons is-centered">
                                <div class="control">
                                    <a
                                        class="button is-small"
                                        href="{{ route('backend.users.edit', [$user]) }}"
                                    >
                                        @icon('fa-pencil')
                                    </a>
                                </div>

                                <div class="control">
                                    <a
                                        class="button is-small"
                                        href="{{ route('backend.users.destroy', [$user]) }}"
                                        data-confirm="@lang('general.confirm')"
                                    >
                                        @icon('fa-trash-can', 'has-text-danger')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $users->appends(request()->input())->links('backend.partials.pagination') }}
        @else
            <div class="section is-medium has-text-centered">
                <p class="block no-records">
                    @lang('users.noRecords')
                </p>

                <p class="block">
                    @include('backend.users.partials.buttons.create')
                </p>
            </div>
        @endif
    </form>
@endsection
