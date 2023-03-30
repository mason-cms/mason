<div class="user user-{{ $user->getKey() }} mb-4 has-text-centered">
    @isset($user->gravatar_url)
        <figure class="user-gravatar image is-128x128 is-centered block">
            <a href="{{ route('workshop.users.edit', [$user]) }}">
                <img
                    class="is-rounded"
                    src="{{ $user->gravatar_url }}?s=128"
                    width="128"
                    height="128"
                />
            </a>
        </figure>
    @endisset

    <h2 class="title is-2">
        {{ $user->name }}
    </h2>

    <div class="subtitle">
        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
    </div>

    <div class="field has-addons is-centered">
        <div class="control">
            <a
                class="button is-small"
                href="{{ route('workshop.users.edit', [$user]) }}"
            >
                @icon('fa-pencil')
            </a>
        </div>

        <div class="control">
            <a
                class="button is-small"
                href="{{ route('workshop.users.destroy', [$user]) }}"
                data-confirm="@lang('general.confirm')"
            >
                @icon('fa-trash-can', 'has-text-danger')
            </a>
        </div>
    </div>
</div>
