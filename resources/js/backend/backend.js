$(window).add(document).on('ready load resize DOMSubtreeModified', function () {
    let windowWidth = $(window).width(),
        $body = $('body').removeClass('is-desktop is-tablet is-mobile');

    if (windowWidth >= 1024) {
        $body.addClass('is-desktop');
    } else if (windowWidth >= 769) {
        $body.addClass('is-tablet');
    } else {
        $body.addClass('is-mobile');
    }
});

$(document).ready(function () {
    $('.code-editor').each(function () {
        let $editor = $(this),
            mode = $editor.data('editor-mode') || "ace/mode/html",
            maxLines = $editor.data('editor-max-lines') || 30,
            input = $editor.data('input');

        let editor = ace.edit(this, {
            mode: mode,
            maxLines: maxLines
        });

        if (typeof input === 'string' && input.length > 0) {
            let $input = $(input);

            if ($input.length > 0) {
                editor.getSession().on('change', function(){
                    $input.val(editor.getSession().getValue());
                });
            }
        }
    });
});
