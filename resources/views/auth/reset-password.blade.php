<form
    method="POST"
    action="{{ route('password.update') }}"
>
    @csrf

    <input
        type="hidden"
        name="token"
        value="{{ $request->route('token') }}"
    >

    <input
        id="email"
        type="email"
        name="email"
        value="{{ old('email', $request->email) }}"
        required
        autofocus
    />

    <input
        id="password"
        type="password"
        name="password"
        required
    />

    <input
        id="password_confirmation"
        type="password"
        name="password_confirmation"
        required
    />

    <button>
        {{ __('Reset Password') }}
    </button>
</form>
