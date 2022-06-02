@extends('layouts.backend')

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
                                {{ __('users.title') }}
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
                @foreach($users as $user)
                    <div class="column is-4-tablet is-3-desktop">
                        <div class="user mb-4 has-text-centered">
                            @isset($user->gravatar_url)
                                <figure class="image is-128x128 is-centered block">
                                    <a href="{{ route('backend.users.edit', [$user]) }}">
                                        <img class="is-rounded" src="{{ $user->gravatar_url }}?s=128">
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
                                        <span class="icon"><i class="fa-light fa-pencil"></i></span>
                                    </a>
                                </div>

                                <div class="control">
                                    <a
                                        class="button is-small"
                                        href="{{ route('backend.users.destroy', [$user]) }}"
                                        data-confirm="{{ __('general.confirm') }}"
                                    >
                                        <span class="icon has-text-danger"><i class="fa-light fa-trash-can"></i></span>
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
                    {{ __('users.no_records') }}
                </p>

                <p class="block">
                    @include('backend.users.partials.buttons.create')
                </p>
            </div>
        @endif
    </form>
@endsection
