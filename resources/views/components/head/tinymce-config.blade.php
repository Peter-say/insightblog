<script src="https://cdn.tiny.cloud/1/9kceokxig3p7h7aj82ykjwy3ohrak2bq8wozjh90w23fr1mz/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#myeditorinstance',
        plugins: 'code table lists image',
        toolbar: 'undo redo | blocks | bold italic | link image | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
        automatic_uploads: true,
        images_upload_handler: function(blobInfo, success, failure) {
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
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
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
        }
    });
</script>
