<form
    method="POST"
    action="{{ route('register') }}"
>
    @csrf

    <input
        id="name"
        type="text"
        name="name"
        value="{{ old('name') }}"
        required
        autofocus
    />

    <input
        id="email"
        type="email"
        name="email"
        value="{{ old('email') }}"
        required
    />

    <input
        id="password"
        type="password"
        name="password"
        required
        autocomplete="new-password"
    />

    <input
        id="password_confirmation"
        type="password"
        name="password_confirmation"
        required
    />

    <a href="{{ route('login') }}">
        {{ __('Already registered?') }}
    </a>

    <button>
        {{ __('Register') }}
    </button>
</form>
