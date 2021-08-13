$(document).ready(function() {
    $('#summernote').summernote({
        height: 300,
        minHeight: 300,
        maxHeight: 500,
        focus: true,
        lang: "ko-KR",
        placeholder: '리뷰 작성',
        callbacks: {
            onImageUpload: function(files) {
                for(let i = 0; i < files.length; i++) {
                    if(i > 10) {
                        alert('10개 까지만 등록할 수 있습니다.');
                        return;
                    }
                }
                for(let i = 0; i < files.length; i++) {
                    if(i > 10) {
                        alert('10개 까지만 등록할 수 있습니다.');
                        return;
                    }
                    sendFile($summernote, files[i]);
                }
            }
        }
    });
});

function sendFile($summernote, file) {
    let formData = new FormData();
    formData.append("file", file);
    $.ajax({
        url: './saveImage.php',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data) {
            if(data === -1) {
                alert('용량이 너무 크거나 이미지 파일이 아닙니다.');
                return;
            } else {
                $summernote.summernote('insertImage', data, function($image) {
                    $image.attr('src', data);
                    $image.attr('class', 'childImg');
                });
                let imgUrl = $("#imgUrl").val();
                if(imgUrl) {
                    imgUrl = imgUrl + ",";
                }
                $("#imgUrl").val(imgUrl + data);
            }
        }
    });
}

let postForm = function() {
    let contents = $('textarea[name="contents"]').html($('#sumernote').code());
}