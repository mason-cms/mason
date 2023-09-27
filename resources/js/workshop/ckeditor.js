/**
 * CKEditor
 * @see https://ckeditor.com/docs/ckeditor5/latest/
 */

$(document).ready(function () {
    $('.ck-editor').each(function () {
        let $ckEditor = $(this),
            base64 = $ckEditor.data('base64'),
            html = base64Decode(base64),
            input = $ckEditor.data('input'),
            $input = typeof input === 'string' ? $(input) : null;

        ClassicEditor
            .create(this, {
                extraPlugins: [MasonUploadAdapterPlugin],
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
            .then(function (ckEditor) {
                ckEditor.setData(html);

                if ($input && $input.length > 0) {
                    $input.val(base64);

                    ckEditor.model.document.on('change:data', function () {
                        html = ckEditor.getData();
                        base64 = base64Encode(html);
                        $input.val(base64);
                    });
                }
            })
            .catch(error => {
                console.error(error);
            });
    });
});

class MasonUploadAdapter
{
    constructor(loader, url)
    {
        this.loader = loader;
        this.url = url;
    }

    upload()
    {
        return this.loader.file
            .then(file => new Promise((resolve, reject) => {
                this._initRequest();
                this._initListeners(resolve, reject, file);
                this._sendRequest(file);
            }));
    }

    abort()
    {
        if (this.xhr) {
            this.xhr.abort();
        }
    }

    _initRequest()
    {
        const xhr = this.xhr = new XMLHttpRequest();

        xhr.open('POST', this.url, true);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.responseType = 'json';
    }

    _initListeners(resolve, reject, file)
    {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${file.name}.`;

        xhr.addEventListener('error', () => reject(genericErrorText));
        xhr.addEventListener('abort', () => reject());
        xhr.addEventListener('load', () => {
            const response = xhr.response;

            if (! response || response.error) {
                return reject(response && response.error ? response.error.message : genericErrorText);
            }

            resolve({
                default: response.url
            });
        });

        if (xhr.upload) {
            xhr.upload.addEventListener('progress', evt => {
                if (evt.lengthComputable) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            });
        }
    }

    // Prepares the data and sends the request.
    _sendRequest(file) {
        const data = new FormData();

        data.append('medium[file]', file);

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        this.xhr.setRequestHeader('x-csrf-token', csrfToken);

        this.xhr.send(data);
    }
}

function MasonUploadAdapterPlugin(editor)
{
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MasonUploadAdapter(loader, editor.sourceElement.dataset.mediaUpload);
    };
}
