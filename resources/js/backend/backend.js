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

    /**
     * Init Ace Code Editor
     * @see https://ace.c9.io/
     */
    $('textarea.is-code').each(function () {
        let $textarea = $(this).hide(),
            editorMode = $textarea.data('editor-mode') || "ace/mode/html",
            editorMaxLines = $textarea.data('editor-max-lines') || $textarea.attr('rows') || 30;

        let $editor = $('<div />')
            .addClass('code-editor')
            .css('min-height', editorMaxLines + 'em')
            .insertAfter($textarea);

        let editor = ace.edit($editor.get(0), {
            mode: editorMode,
            maxLines: parseInt(editorMaxLines),
            useWorker: false
        });

        editor.setValue($textarea.val(), -1);

        editor.session.on('change', function() {
            $textarea.val(editor.session.getValue());
        });
    });

    $('textarea.is-markdown').each(function () {
        let $textarea = $(this).hide(),
            editorMode = $textarea.data('editor-mode') || "ace/mode/markdown",
            editorMaxLines = $textarea.data('editor-max-lines') || $textarea.attr('rows') || 30;

        let $editor = $('<div />')
            .addClass('code-editor', 'markdown-editor')
            .css('min-height', editorMaxLines + 'em')
            .insertAfter($textarea);

        let editor = ace.edit($editor.get(0), {
            mode: editorMode,
            maxLines: parseInt(editorMaxLines),
            useWorker: false
        });

        editor.setValue($textarea.val(), -1);

        editor.session.on('change', function() {
            $textarea.val(editor.session.getValue());
        });
    });

    /**
     * CKEditor
     * @see https://ckeditor.com/docs/ckeditor5/latest/
     */
    $('textarea.is-wysiwyg').each(function () {
        ClassicEditor
            .create(this)
            .catch(error => {
                console.error(error);
            });
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
