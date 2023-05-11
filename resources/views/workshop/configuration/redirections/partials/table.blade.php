<div class="table-container">
    <table class="table is-fullwidth">
        <thead>
            <tr>
                <th class="is-narrow"></th>

                <th>
                    @lang('redirections.attributes.source')
                </th>

                <th>
                    @lang('redirections.attributes.target')
                </th>

                <th>
                    @lang('redirections.attributes.http_response_code')
                </th>

                <th>
                    @lang('redirections.attributes.comment')
                </th>

                <th>
                    @lang('redirections.hits.plural')
                </th>

                <th>
                    @lang('redirections.attributes.last_hit_at')
                </th>

                <th class="is-narrow"></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($redirections as $redirection)
                <tr>
                    <td>
                        <span
                            class="{{ $redirection->is_active ? 'has-text-success' : 'has-text-light' }}"
                            title="{{ $redirection->is_active ? __('redirections.attributes.active') : __('redirections.attributes.inactive') }}"
                        >
                            @icon('fa-circle')
                        </span>
                    </td>

                    <td>
                        /{{ $redirection->source }}
                    </td>

                    <td>
                        @isset($redirection->target)
                            <a
                                href="{{ $redirection->target }}"
                                target="_blank"
                            >
                                {{ $redirection->target }}
                            </a>
                        @endisset
                    </td>

                    <td>
                        {{ $redirection->http_response_code }}
                    </td>

                    <td>
                        {{ $redirection->comment }}
                    </td>

                    <td>
                        {{ $redirection->hits()->count() }}
                    </td>

                    <td>
                        {{ $redirection->last_hit_at }}
                    </td>

                    <td>
                        <div class="field is-grouped">
                            <div class="control">
                                <a
                                    class="button"
                                    href="{{ route('workshop.configuration.redirection.edit', [$redirection]) }}"
                                >
                                    @icon('fa-pencil')
                                    <span class="is-hidden-mobile">@lang('redirections.actions.edit.label')</span>
                                </a>
                            </div>

                            <div class="control">
                                <a
                                    class="button"
                                    href="{{ route('workshop.configuration.redirection.destroy', [$redirection]) }}"
                                    data-confirm="@lang('general.confirm')"
                                    data-method="DELETE"
                                >
                                    @icon('fa-trash-can')
                                    <span class="is-hidden-mobile">@lang('redirections.actions.destroy.label')</span>
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
