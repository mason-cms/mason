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

        @if ($user->exists)
            <div class="card block">
                <div class="card-content">
                    <div class="tabs">
                        <ul>
                            @foreach ($user->profiles as $userProfile)
                                <li>
                                    <a href="#user-profile-{{ $userProfile->locale->name }}">
                                        {{ $userProfile->locale }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    @foreach ($user->profiles as $userProfile)
                        <fieldset id="user-profile-{{ $userProfile->locale->name }}">
                            <input
                                name="user[profiles][{{ $key = \Illuminate\Support\Str::random() }}][id]"
                                type="hidden"
                                value="{{ $userProfile->id }}"
                            />

                            <div class="field">
                                <label class="label">
                                    @lang('userProfiles.attributes.bio')
                                </label>

                                <textarea
                                    class="textarea"
                                    name="user[profiles][{{ $key }}][bio]"
                                    rows="5"
                                >{!! $userProfile->bio !!}</textarea>
                            </div>
                        </fieldset>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($user->exists)
            <div class="card block">
                <div class="card-content">
                    <div class="table-container">
                        <table class="table is-fullwidth">
                            <thead>
                                <tr>
                                    <th>
                                        @lang('userLinks.attributes.title')
                                    </th>

                                    <th>
                                        @lang('userLinks.attributes.url')
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($user->links as $userLink)
                                    @include('workshop.users.partials.links.row')
                                @endforeach

                                @for ($i = 0; $i < 3; $i++)
                                    @include('workshop.users.partials.links.row', ['userLink' => $user->links()->make()])
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="column is-5">
        @if ($user->exists)
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
        @endif
    </div>
</div>
