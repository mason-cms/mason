$(document)
    .on('click', '[rel="open-modal"]', function (e) {
        e.preventDefault();

        let $this = $(this),
            href = $this.attr('href'),
            $modal;

        if (typeof href === 'string' && href.length > 0 && href.indexOf("#") === 0) {
            $modal = $(href);
            $modal.trigger('mason:modal:open');
        } else {
            let $modalContainer = $('<div class="modal-container"></div>');

            $modalContainer
                .appendTo($('body'))
                .load(href, function () {
                    $modal = $modalContainer.children('.modal').last().addClass('is-ajax');
                    $modal.trigger('mason:modal:open');
                });
        }
    })
    .on('click', '[rel="close-modal"]', function (e) {
        e.preventDefault();

        let $this = $(this),
            href = $this.attr('href'),
            $modal;

        if (typeof href === 'string' && href.length > 0 && href.indexOf("#") === 0) {
            $modal = (href);
        } else {
            $modal = $this.parents('.modal').first();
        }

        $modal.trigger('mason:modal:close');
    })
    .on('click', '.modal-background', function (e) {
        e.preventDefault();

        let $modalBackground = $(this),
            $modal = $modalBackground.parents('.modal').first();

        $modal.trigger('mason:modal:close');
    })
    .on('keyup', function (e) {
        if (e.key === "Escape") {
            $('.modal.is-active').trigger('mason:modal:close');
        }
    })
    .on('mason:modal:open', '.modal', function () {
        let $modal = $(this);

        $modal.addClass('is-active');
        $('html').addClass('is-clipped');

        $modal.trigger('mason:modal:open:done');
    })
    .on('mason:modal:close', '.modal', function () {
        let $modal = $(this);

        $modal.removeClass('is-active');

        if ($('.modal.is-active').length === 0) {
            $('html').removeClass('is-clipped');
        }

        $modal.trigger('mason:modal:close:done');

        if ($modal.hasClass('is-ajax')) {
            $modal.remove();
        }
    });
