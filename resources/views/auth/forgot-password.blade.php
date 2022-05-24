<form
    method="POST"
    action="{{ route('password.email') }}"
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

    <button>
        {{ __('Email Password Reset Link') }}
    </button>
</form>
