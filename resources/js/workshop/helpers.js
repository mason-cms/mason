$(document)
    .on('change sortupdate', 'form.autosave', function () {
        $(this).submit();
    })
    .on('click', '[data-clear]', function (e) {
        e.preventDefault();

        let $this = $(this),
            target = $this.data('clear'),
            $target = $(target),
            $inputs = $target.find(':input');

        $inputs.val('').prop('checked', false);

        if ($this.attr('type') === 'submit') {
            $target.parents('form').submit();
        }
    })
    .on('input', 'input.slug', function () {
        let $input = $(this),
            slug = $input.val()
                .toLowerCase()
                .normalize("NFD")
                .replace(/ /g,'-')
                .replace(/[^\w-]+/g,'');

        $input.val(slug);
    })
    .on('focus', 'input.slug[data-slug-from]', function () {
        let $input = $(this),
            from = $input.data('slug-from'),
            $from = $(from).first();

        if (! $input.val() && $from.length === 1) {
            let slug = $from.val()
                .toLowerCase()
                .normalize("NFD")
                .replace(/ /g,'-')
                .replace(/[^\w-]+/g,'');

            $input.val(slug).trigger('input');
        }
    })
    .on('change', '.file .file-input', function (e) {
        let $fileInput = $(this),
            $file = $fileInput.parents('.file').first(),
            $fileLabel = $file.find('label.file-label').first(),
            $fileName = $file.find('.file-name').first();

        $file.addClass('has-name');

        if ($fileName.length === 0) {
            $fileName = $('<span class="file-name"></span>').appendTo($fileLabel);
        }

        if (typeof e.target.files === 'object' && e.target.files.length > 0) {
            let fileNames = [];

            for (let i = 0; i < e.target.files.length; i++) {
                fileNames.push(e.target.files[i].name);
            }

            $fileName.text(fileNames.join(', '));
        } else {
            $fileName.text('');
        }
    })
    .on('click', '[data-confirm]', function () {
        return window.confirm($(this).data('confirm'));
    })
    .on('mason:lockable:init', '.is-lockable', function (e) {
        let $this = $(this),
            $input = $this.find('.input'),
            $lock = $this.find('.lock'),
            $unlock = $this.find('.unlock');

        if ($this.hasClass('is-locked') || $input.prop('disabled')) {
            $this.trigger('mason:lockable:lock');
        } else {
            $this.trigger('mason:lockable:unlock');
        }

        $lock.on('click', function (e) {
            e.preventDefault();

            $this.trigger('mason:lockable:lock');
        });

        $unlock.on('click', function (e) {
            e.preventDefault();

            $this.trigger('mason:lockable:unlock');
        });
    })
    .on('mason:lockable:lock', '.is-lockable', function () {
        let $this = $(this),
            $input = $this.find('.input'),
            $lock = $this.find('.lock'),
            $unlock = $this.find('.unlock');

        $this.addClass('is-locked');
        $input.prop('disabled', true);
        $lock.addClass('is-hidden');
        $unlock.removeClass('is-hidden');
    })
    .on('mason:lockable:unlock', '.is-lockable', function () {
        let $this = $(this),
            $input = $this.find('.input'),
            $lock = $this.find('.lock'),
            $unlock = $this.find('.unlock');

        $this.removeClass('is-locked');
        $input.prop('disabled', false);
        $unlock.addClass('is-hidden');
        $lock.removeClass('is-hidden');
    })
    .on('ready DOMSubtreeModified', function () {
        $('.is-lockable').trigger('mason:lockable:init');
    })
    .on('click', '[rel="expand"]', function (e) {
        e.preventDefault();

        let $this = $(this),
            href = $this.attr('href'),
            $href = $(href);

        $href.removeClass('is-hidden');
    })
    .on('click', '[rel="collapse"]', function (e) {
        e.preventDefault();

        let $this = $(this),
            href = $this.attr('href'),
            $href = $(href);

        $href.addClass('is-hidden');
    })
    .on('click', '[rel="toggle"]', function (e) {
        e.preventDefault();

        let $this = $(this),
            href = $this.attr('href'),
            $href = $(href);

        $href.toggleClass('is-hidden');
    })
    .on('click', '[data-method]', function (e) {
        e.preventDefault();

        let $this = $(this),
            method = $this.data('method'),
            href = $this.attr('href');

        let $form = $('<form>')
            .attr('action', href)
            .attr('method', 'POST')
            .append(
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', '_method')
                    .attr('value', method)
            )
            .append(
                $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', '_token')
                    .attr('value', $('meta[name="csrf-token"]').attr('content'))
            )
            .appendTo('body');

        return $form.submit();
    })
    .on('keydown', function (e) {
        /**
         * CTRL+S
         * Take over the control+save key to trigger click events on elements with 'save' class
         */
        if ((e.metaKey || e.ctrlKey) && e.keyCode === 83) {
            let $save = $('.save');

            if ($save.length > 0) {
                e.preventDefault();
                $save.click();
                return false;
            }
        }
    });
