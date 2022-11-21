/**
 * CKEditor
 * @see https://ckeditor.com/docs/ckeditor5/latest/
 */

$(document).ready(function () {
    $('.ck-editor').each(function () {
        ClassicEditor
            .create(this, {
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    });
});
