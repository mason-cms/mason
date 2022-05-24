<form
    method="POST"
    action="{{ route('login') }}"
>
    @csrf

    <input
        id="email"
        type="email"
        name="email"
        value="{{ old('email') }}"
        required
        autofocus
    />

    <input
        id="password"
        type="password"
        name="password"
        required
        autocomplete="current-password"
    />

    <label for="remember_me">
        <input
            id="remember_me"
            type="checkbox"
            name="remember"
        >
        <span>{{ __('Remember me') }}</span>
    </label>

    @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
        </a>
    @endif

    <button>
        {{ __('Log in') }}
    </button>
</form>
