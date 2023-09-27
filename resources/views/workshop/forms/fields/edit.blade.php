<x-modal
    id="edit-form-field-modal"
>
    <form
        class="modal-card"
        action="{{ route('workshop.forms.fields.update', [$field->form, $field]) }}"
        method="POST"
    >
        @method('PATCH')
        @csrf

        <header class="modal-card-head">
            <h3 class="title is-3 modal-card-title">
                @lang('forms.fields.actions.edit.title')
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
