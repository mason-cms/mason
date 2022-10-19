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
    /**
     * Init jQuery UI plugins
     */
    $('.ui-sortable').sortable();

    $('.code-editor').each(function () {
        let $editor = $(this),
            editorMode = $editor.data('editor-mode') || "ace/mode/html",
            editorMaxLines = $editor.data('editor-max-lines') || 30,
            editorInput = $editor.data('editor-input');

        let editor = ace.edit(this, {
            mode: editorMode,
            maxLines: editorMaxLines,
            useWorker: false
        });

        if (typeof editorInput === 'string' && editorInput.length > 0) {
            let $editorInput = $(editorInput);

            if ($editorInput.length > 0) {
                editor.session.on('change', function() {
                    console.log(editor.session.getValue());
                    $editorInput.val(editor.session.getValue());
                });
            }
        }
    });
});

$(document)
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
            $fileName.text(e.target.files[0].name);
        } else {
            $fileName.text('');
        }
    });
