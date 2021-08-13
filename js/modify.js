$(document).ready(function() {
    $('#summernote').summernote({
        height: 300,
        minHeight: 300,
        maxHeight: 500,
        focus: true,
        lang: "ko-KR",
        placeholder: '리뷰 작성',

    });
});


let postForm = function() {
    let contents = $('textarea[name="contents"]').html($('#sumernote').code());
}