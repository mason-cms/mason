@extends('layouts.auth')

@section('content')
    <form
        id="register-form"
        class="card block is-narrow"
        method="POST"
        action="{{ route('register') }}"
    >
        @csrf

        <div class="card-content">
            <div class="field">
                <div class="control">
                    <input
                        class="input"
                        type="text"
                        name="name"
                        placeholder="{{ __('users.attributes.name') }}"
                        value="{{ old('name') }}"
                        required
                        autofocus
                    />
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input
                        class="input"
                        type="email"
                        name="email"
                        placeholder="{{ __('users.attributes.email') }}"
                        value="{{ old('email') }}"
                        required
                    />
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input
                        class="input"
                        type="password"
                        name="password"
                        placeholder="{{ __('users.attributes.password') }}"
                        required
                        autocomplete="new-password"
                    />
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input
                        class="input"
                        type="password"
                        name="password_confirmation"
                        placeholder="{{ __('users.attributes.password_confirmation') }}"
                        required
                    />
                </div>
            </div>

            <div class="level is-mobile">
                <div class="level-left">
                    <div class="level-item">
                        <button class="button is-primary" type="submit">
                            {{ __('auth.register') }}
                        </button>
                    </div>
                </div>

                <div class="level-right">
                    <div class="level-item">
                        <a href="{{ route('login') }}">
                            {{ __('auth.already_registered') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
