<form
    method="POST"
    action="{{ route('password.confirm') }}"
>
    @csrf

    <input
        id="password"
        type="password"
        name="password"
        required
        autocomplete="current-password"
    />

    <button>
        @lang('Confirm')
    </button>
</form>
