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

                        <div class="pagination-count">
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
            <div class="card block">
                <div class="card-content">
                    <div class="table-container">
                        <table class="table is-fullwidth">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('users.attributes.name') }}
                                    </th>

                                    <th>
                                        {{ __('users.attributes.email') }}
                                    </th>

                                    <th>
                                        {{ __('entries.plural') }}
                                    </th>

                                    <th class="is-narrow"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            {{ $user->name }}
                                        </td>

                                        <td>
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        </td>

                                        <td>
                                            {{ $user->entries()->count() }}
                                        </td>

                                        <td>
                                            <div class="field is-grouped">
                                                <div class="control">
                                                    <a class="button is-small" href="{{ route('backend.users.edit', [$user]) }}">
                                                        <span class="icon"><i class="fa-light fa-pencil"></i></span>
                                                    </a>
                                                </div>

                                                <div class="control">
                                                    <form action="{{ route('backend.users.destroy', [$user]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button class="button is-small is-danger" type="submit" data-confirm="{{ __('general.confirm') }}">
                                                            <span class="icon"><i class="fa-light fa-trash-can"></i></span>
                                                        </button>
                                                    </form>
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
