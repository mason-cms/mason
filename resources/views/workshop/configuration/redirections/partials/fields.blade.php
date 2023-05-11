<div class="card">
    <div class="card-content">
        <div class="columns is-multiline">
            <div class="column is-6">
                <div class="field">
                    <label class="label">
                        @lang('redirections.attributes.source')
                    </label>

                    <div class="field has-addons">
                        <div class="control">
                            <a class="button is-static">
                                /
                            </a>
                        </div>

                        <div class="control is-expanded">
                            <input
                                class="input"
                                type="text"
                                name="redirection[source]"
                                value="{{ $redirection->source }}"
                                required
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="column is-6">
                <div class="field">
                    <label class="label">
                        @lang('redirections.attributes.target')
                    </label>

                    <div class="field has-addons">
                        <div class="control">
                            <a class="button is-static">
                                @icon('fa-arrow-right')
                            </a>
                        </div>

                        <div class="control is-expanded">
                            <input
                                class="input"
                                type="text"
                                name="redirection[target]"
                                value="{{ $redirection->target }}"
                                required
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label">
                @lang('redirections.attributes.comment')
            </label>

            <div class="control">
                <input
                    class="input"
                    type="text"
                    name="redirection[comment]"
                    value="{{ $redirection->comment }}"
                />
            </div>
        </div>

        <div class="field">
            <div class="control">
                <input
                    type="hidden"
                    name="redirection[is_active]"
                    value="0"
                />

                <label class="checkbox">
                    <input
                        type="checkbox"
                        name="redirection[is_active]"
                        value="1"
                        {{ $redirection->is_active ? 'checked' : '' }}
                    /> @lang('redirections.attributes.is_active')
                </label>
            </div>
        </div>
    </div>
</div>
