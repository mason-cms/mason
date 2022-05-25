$(document).on('ready', function () {
    var $body = $('body');

    $(document).on('mason:sameHeight:resize', '.same-height-cards', function () {
        var $group = $(this),
            $cards = $group.find('.card'),
            maxHeight = 0;

        $cards.each(function () {
            var $card = $(this),
                $spacer = $card.children('.card-spacer').height(0),
                height = parseInt($card.height());

            if (height > maxHeight) maxHeight = height;
        });

        if (! $body.hasClass('is-mobile')) {
            $cards.each(function () {
                var $card = $(this),
                    height = parseInt($card.height()),
                    $spacer = $card.children('.card-spacer').last(),
                    spacing = maxHeight - height;

                $spacer.height(spacing);
            });
        }
    });
});

$(window).add(document).on('ready load resize', function () {
    $('.same-height-cards').trigger('mason:sameHeight:resize');
});
