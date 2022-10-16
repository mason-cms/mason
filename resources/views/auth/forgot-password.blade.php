@extends('auth.layout')

@section('content')
    <form
        id="forgot-password-form"
        class="card block is-narrow"
        method="POST"
        action="{{ route('password.email') }}"
    >
        @csrf

        <div class="card-content">
            <div class="field">
                <div class="control">
                    <input
                        class="input"
                        type="email"
                        name="email"
                        placeholder="@lang('users.attributes.email')"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    />
                </div>
            </div>

            <button
                class="button is-primary"
                type="submit"
            >
                @lang('auth.email_password_reset_link')
            </button>
        </div>
    </form>
@endsection
