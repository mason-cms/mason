<form
    id="edit-menu-item-form"
    class="modal"
    action="{{ route('backend.menus.items.update', [$menu, $item]) }}"
    method="POST"
>
    @method('PATCH')
    @csrf

    <div class="modal-background"></div>

    <div class="modal-card">
        <header class="modal-card-head">
            <h3 class="title is-3 modal-card-title">
                @lang('menus.items.actions.edit.label')
            </h3>
        </header>

        <section class="modal-card-body">
            @include('backend.menus.items.partials.fields')
        </section>

        <footer class="modal-card-foot">
            <button
                class="button save is-success"
                type="submit"
            >
                @icon('fa-floppy-disk')
                <span>@lang('menus.items.actions.save.label')</span>
            </button>
        </footer>
    </div>

    <button
        class="modal-close is-large"
        aria-label="close"
        rel="close-modal"
    ></button>
</form>
