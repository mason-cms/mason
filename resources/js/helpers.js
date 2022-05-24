$(document)
    .on('change', 'form.autosave', function () {
        $(this).submit();
    })
    .on('click', '[data-clear]', function (e) {
        e.preventDefault();

        var $this = $(this),
            target = $this.data('clear'),
            $target = $(target),
            $inputs = $target.find(':input');

        $inputs.val('').prop('checked', false);

        if ($this.attr('type') === 'submit') {
            $target.parents('form').submit();
        }
    })
    .on('input', 'input.slug', function () {
        var $input = $(this),
            val = $input.val(),
            slug = val.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');

        $input.val(slug);
    })
    .on('click', '[data-confirm]', function () {
        return window.confirm($(this).data('confirm'));
    });
