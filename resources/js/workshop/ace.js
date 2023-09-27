/**
 * Init Ace Code Editor
 * @see https://ace.c9.io/
 */

$(document).ready(function () {
    $('.ace-editor').each(function () {
        let $this = $(this).hide(),
            base64 = $this.data('base64'),
            html = base64Decode(base64),
            editorMode = $this.data('editor-mode'),
            editorMaxLines = $this.data('editor-max-lines') || $this.attr('rows') || 30,
            input = $this.data('input'),
            $input = input ? $(input) : null,
            $form = $input ? $input.parents('form').first() : null;

        if (! editorMode) {
            if ($this.hasClass('is-code') || $this.hasClass('is-html')) {
                editorMode = "ace/mode/html";
            } else if ($this.hasClass('is-markdown')) {
                editorMode = "ace/mode/markdown";
            }
        }

        if ($input) {
            $input.val(base64);
        }

        let $editor = $('<div />')
            .addClass('code-editor')
            .css('min-height', editorMaxLines + 'em')
            .insertAfter($this);

        let editor = ace.edit($editor.get(0), {
            mode: editorMode,
            maxLines: parseInt(editorMaxLines),
            useWorker: false
        });

        editor.setValue(html, -1);

        if ($form && $input) {
            $form.on('submit', function () {
                html = editor.session.getValue();
                base64 = base64Encode(html);
                $input.val(base64);
                return true;
            });
        }
    });
});
