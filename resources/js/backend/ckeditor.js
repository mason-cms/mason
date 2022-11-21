/**
 * CKEditor
 * @see https://ckeditor.com/docs/ckeditor5/latest/
 */

$(document).ready(function () {
    $('.ck-editor').each(function () {
        ClassicEditor
            .create(this)
            .catch(error => {
                console.error(error);
            });
    });
});
