@extends('layouts.auth')

@section('content')
    <form
        id="reset-password-form"
        class="card block is-narrow"
        method="POST"
        action="{{ route('password.update') }}"
    >
        @csrf

        <input
            type="hidden"
            name="token"
            value="{{ $request->route('token') }}"
        >

        <div class="card-content">
            <div class="field">
                <div class="control">
                    <input
                        type="email"
                        name="email"
                        placeholder="{{ __('users.attributes.email') }}"
                        value="{{ old('email', $request->email) }}"
                        required
                        autofocus
                    />
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input
                        type="password"
                        name="password"
                        placeholder="{{ __('users.attributes.password') }}"
                        required
                    />
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="{{ __('users.attributes.password_confirmation') }}"
                        required
                    />
                </div>
            </div>

            <button class="button is-primary" type="submit">
                {{ __('auth.reset_password') }}
            </button>
        </div>
    </form>
@endsection
