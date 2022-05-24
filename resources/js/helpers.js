$(document)
    .on('change', 'form.autosave', function () {
        $(this).submit();
    })
    .on('click', 'form button[type="clear"]', function (e) {
        e.preventDefault();

        var $button = $(this),
            $form = $button.parents('form').first(),
            $inputs = $form.find(':input');

        $inputs.val('').prop('checked', false);

        $form.submit();
    })
    .on('click', '[data-confirm]', function () {
        return window.confirm($(this).data('confirm'));
    });
