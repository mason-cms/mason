<div class="columns">
    <div class="column is-4">
        <div class="card block">
            <div class="card-content">
                <div class="field">
                    <label class="label">
                        @lang('users.attributes.name')
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            name="user[name]"
                            value="{{ $user->name }}"
                            maxlength="255"
                            required
                        />
                    </div>
                </div>

                <div class="field">
                    <label class="label">
                        @lang('users.attributes.email')
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            type="email"
                            name="user[email]"
                            value="{{ $user->email }}"
                            maxlength="255"
                            required
                        />
                    </div>
                </div>

                <div class="field">
                    <label class="label">
                        @lang('users.attributes.password')
                    </label>

                    <div class="control">
                        <input
                            class="input"
                            type="password"
                            name="user[password]"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="column is-8">
        <div class="card block">
            <div class="card-content">
                <div class="tabs">
                    <ul>
                        @foreach (\App\Models\Locale::all() as $locale)
                            <li>
                                <a href="#user-profile-{{ $locale->name }}">
                                    {{ $locale }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @foreach (\App\Models\Locale::all() as $locale)
                    <fieldset id="user-profile-{{ $locale->name }}">
                        @if ($userProfile = $user->getProfile($locale))
                            <input
                                name="user[profiles][{{ $userProfile->id }}][locale_id]"
                                type="hidden"
                                value="{{ $userProfile->locale_id }}"
                            />

                            <div class="field">
                                <label class="label">
                                    @lang('userProfiles.attributes.bio')
                                </label>

                                <textarea
                                    class="textarea"
                                    name="user[profiles][{{ $userProfile->id }}][bio]"
                                    rows="5"
                                >{!! $userProfile->bio !!}</textarea>
                            </div>
                        @endif
                    </fieldset>
                @endforeach
            </div>
        </div>
    </div>
</div>
