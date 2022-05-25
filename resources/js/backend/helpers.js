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
            slug = $input.val().toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');

        $input.val(slug);
    })
    .on('focus', 'input.slug[data-slug-from]', function () {
        var $input = $(this),
            from = $input.data('slug-from'),
            $from = $(from).first();

        if (! $input.val() && $from.length === 1) {
            var slug = $from.val().toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');

            $input.val(slug).trigger('input');
        }
    })
    .on('click', '[data-confirm]', function () {
        return window.confirm($(this).data('confirm'));
    });
