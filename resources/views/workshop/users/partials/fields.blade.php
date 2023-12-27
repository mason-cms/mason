<div class="columns">
    <div class="column is-7">
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

    <div class="column is-5">
        <div class="card block">
            <div class="card-content">
                <div class="field">
                    <label
                        class="label"
                        for="user-photo"
                    >@lang('users.attributes.photo')</label>

                    @isset($user->photo)
                        <figure class="image block">
                            <img
                                src="{{ $user->photo->url }}"
                                width="{{ $user->photo->image_width }}"
                                height="{{ $user->photo->image_height }}"
                                alt="{{ $user }}"
                            />
                        </figure>
                    @endisset

                    <div class="control block">
                        <div class="select is-fullwidth">
                            <select
                                id="user-photo"
                                name="user[photo_id]"
                                autocomplete="off"
                            >
                                <option></option>

                                @foreach (\App\Models\Medium::images()->get() as $image)
                                    <option
                                        value="{{ $image->getKey() }}"
                                        {{ isset($user->photo) && $user->photo->is($image) ? 'selected' : '' }}
                                    >{{ $image }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="control block">
                        <div class="file is-small">
                            <label class="file-label">
                                <input
                                    id="user-photo-file"
                                    class="file-input"
                                    type="file"
                                    name="user[photo_file]"
                                />

                                <span class="file-cta">
                                    <span class="file-icon">@i('fa-upload')</span>

                                    <span class="file-label">
                                        @lang('general.file.cta.label')
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
