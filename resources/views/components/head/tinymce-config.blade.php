<script src="https://cdn.tiny.cloud/1/9kceokxig3p7h7aj82ykjwy3ohrak2bq8wozjh90w23fr1mz/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea#myeditorinstance',
        plugins: 'code table lists image link',
        toolbar: 'undo redo | blocks | bold italic | link image | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
        automatic_uploads: true,
        images_upload_handler: function (blobInfo, success, failure) {
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            fetch('{{ route('dashboard.blog.upload-image') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.url) {
                    success(result.url);
                } else {
                    failure(result.error ? result.error : 'Upload failed');
                }
            })
            .catch(error => {
                failure('Upload failed: ' + error.message);
            });
        },
        images_reuse_filename: true,
        image_title: true,
        paste_data_images: false,
        content_style: 'img { max-width: 100%; height: auto; }',
        file_picker_types: 'image',
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function () {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    // Call the callback and populate the Title field with the file name
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        }
    });
</script>
