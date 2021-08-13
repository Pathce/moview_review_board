$(document).ready(function() {
    $('#summernote').summernote({
        height: 300,
        minHeight: 300,
        maxHeight: 500,
        focus: true,
        lang: "ko-KR",
        placeholder: '리뷰 작성',
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
            }
        },
    });
});

function sendFile(file, editor, welEditable) {
    let data = new FormData();
    data.append("uploadFile", file);
    $.ajax({
        data: formData,
        type: "POST",
        url: "./review_write_ok.php",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            editor.insertImage(welEditable, data.url);
        }
    });
}

let postForm = function() {
    let contents = $('textarea[name="contents"]').html($('#sumernote').code());
}