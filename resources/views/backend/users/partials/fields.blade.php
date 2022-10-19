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
