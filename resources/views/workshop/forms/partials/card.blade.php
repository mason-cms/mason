<div
    id="form-{{ $form->getKey() }}"
    class="card"
>
    <div class="card-content">
        <div class="block">
            <h2 class="title is-2">
                <a href="{{ route('workshop.forms.edit', [$form]) }}">
                    {{ $form->title ?? __('forms.untitled') }}
                </a>
            </h2>

            <div class="subtitle is-family-code">
                {{ $form->name }}
            </div>
        </div>

        @isset($form->description)
            <div class="block">
                {!! $form->description !!}
            </div>
        @endisset

        <div class="block form-meta">
            <div class="field is-grouped is-grouped-multiline">
                @isset($form->locale)
                    <div
                        class="control form-locale"
                        title="@lang('forms.attributes.locale')"
                    >
                        @icon('fa-language')
                        <span>{{ $form->locale }}</span>
                    </div>
                @endisset
            </div>
        </div>
    </div>

    <div class="card-footer">
        <a
            class="card-footer-item"
            href="{{ route('workshop.forms.edit', [$form]) }}"
        >
            @icon('fa-pencil')
            <span class="is-hidden-mobile">@lang('forms.actions.edit.label')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('workshop.forms.submissions.index', [$form]) }}"
        >
            @icon(\App\Models\FormSubmission::ICON)
            <span class="is-hidden-mobile">@lang('forms.submissions.title')</span>
        </a>

        <a
            class="card-footer-item"
            href="{{ route('workshop.forms.destroy', [$form]) }}"
            data-confirm="@lang('general.confirm')"
        >
            @icon('fa-trash-can')
            <span class="is-hidden-mobile">@lang('forms.actions.destroy.label')</span>
        </a>
    </div>
</div>
