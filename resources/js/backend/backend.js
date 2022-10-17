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
            editorMode = $editor.data('editor-mode') || "ace/mode/html",
            editorMaxLines = $editor.data('editor-max-lines') || 30,
            editorInput = $editor.data('editor-input');

        let editor = ace.edit(this, {
            mode: editorMode,
            maxLines: editorMaxLines
        });

        if (typeof editorInput === 'string' && editorInput.length > 0) {
            let $editorInput = $(editorInput);

            if ($editorInput.length > 0) {
                editor.session.on('change', function(delta) {
                    console.log(delta);
                    $editorInput.val(editor.session.getValue());
                });
            }
        }
    });
});
