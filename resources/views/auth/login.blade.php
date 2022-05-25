@extends('layouts.auth')

@section('content')
    <form
        id="login-form"
        class="card block is-narrow"
        method="POST"
        action="{{ route('login') }}"
    >
        @csrf

        <div class="card-content">
            <div class="field">
                <div class="control">
                    <input
                        class="input"
                        type="email"
                        name="email"
                        placeholder="{{ __('users.attributes.email') }}"
                        value="{{ old('email') }}"
                        required
                        autofocus
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
                        autocomplete="current-password"
                    />
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <label class="checkbox">
                        <input
                            type="checkbox"
                            name="remember"
                        >
                        <span>{{ __('auth.remember_me') }}</span>
                    </label>
                </div>
            </div>

            <div class="level is-mobile">
                <div class="level-left">
                    <div class="level-item">
                        <button class="button is-primary" type="submit">
                            <span>{{ __('auth.log_in') }}</span>
                            <span class="icon"><i class="fa-light fa-right-to-bracket"></i></span>
                        </button>
                    </div>
                </div>

                <div class="level-right">
                    @if (Route::has('password.request'))
                        <div class="level-item">
                            <a href="{{ route('password.request') }}">
                                {{ __('auth.forgot_password') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
@endsection
