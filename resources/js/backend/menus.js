$(document)
    .on('change', '#item-target', function () {
        var $itemTarget = $(this),
            $itemTargetOptionSelected = $itemTarget.find('option:selected'),
            itemTargetValue = $itemTarget.val(),
            itemTargetText = $itemTargetOptionSelected.length === 1 ? $itemTargetOptionSelected.text() : '',
            itemTargetUrl = $itemTargetOptionSelected.length === 1 ? $itemTargetOptionSelected.data('url') : '',
            $itemTitle = $('#item-title'),
            $itemHref = $('#item-href');

        if ($itemTitle.length === 1) {
            if (itemTargetValue) {
                $itemTitle.val(itemTargetText);
            } else {
                $itemTitle.val('');
            }
        }

        if ($itemHref.length === 1) {
            $itemHref.val(itemTargetUrl);
        }
    })
    .on('ready', function () {
        /**
         * When a new menu item has just been created it will bear the .is-new class and we should trigger the
         * edit action right away, which will open a modal window.
         */
        $('.menu-item.is-new').first().find('.edit-menu-item').click();
    });
