<x-modal
    id="create-form-field-modal"
>
    <form
        class="modal-card"
        action="{{ route('workshop.forms.fields.store', [$field->form]) }}"
        method="POST"
    >
        @csrf

        <header class="modal-card-head">
            <h3 class="title is-3 modal-card-title">
                @lang('forms.fields.actions.create.label')
            </h3>
        </header>

        <section class="modal-card-body">
            @include('workshop.forms.fields.partials.fields')
        </section>

        <footer class="modal-card-foot">
            <button
                class="button save is-success"
                type="submit"
            >
                @icon('fa-floppy-disk')
                <span>@lang('forms.fields.actions.save.label')</span>
            </button>
        </footer>
    </form>
</x-modal>
