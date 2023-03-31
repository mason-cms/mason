/**
 * Init Ace Code Editor
 * @see https://ace.c9.io/
 */

$(document).ready(function () {
    $('.ace-editor').each(function () {
        let $this = $(this).hide(),
            base64Html = $this.html(),
            html = atob(base64Html),
            editorMode = $this.data('editor-mode'),
            editorMaxLines = $this.data('editor-max-lines') || $this.attr('rows') || 30,
            input = $this.data('input'),
            $input = typeof input === 'string' ? $(input) : null;

        if (! editorMode) {
            if ($this.hasClass('is-code') || $this.hasClass('is-html')) {
                editorMode = "ace/mode/html";
            } else if ($this.hasClass('is-markdown')) {
                editorMode = "ace/mode/markdown";
            }
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

        if ($input && $input.length > 0) {
            $input.val(base64Html);

            editor.session.on('change', function() {
                html = editor.session.getValue();
                base64Html = btoa(html);
                $input.val(base64Html);
            });
        }
    });
});
