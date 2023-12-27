$(document)
    .ready(function () {
        $('.tabs').each(function () {
            let $tabs = $(this),
                $items = $tabs.find('li');

            if ($items.filter('.is-active').length === 0) {
                $items.first().addClass('is-active');
            }

            $items
                .each(function () {
                    let $item = $(this),
                        $link = $item.find('a'),
                        href = $link.attr('href'),
                        $href = $(href);

                    if ($href.length > 0) {
                        $item
                            .on('check', function () {
                                $item.hasClass('is-active') ? $href.show() : $href.hide();
                            })
                            .on('click', function (e) {
                                e.preventDefault();

                                $items.removeClass('is-active').trigger('check');
                                $item.addClass('is-active').trigger('check');
                            })
                            .trigger('check');
                    }
                });
        });
    });
