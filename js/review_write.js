$(document).ready(function() {
    $('#summernote').summernote({
        height: 300,
        minHeight: 300,
        maxHeight: 500,
        focus: true,
        lang: "ko-KR",
        placeholder: '리뷰 작성',
        // callbacks: {
        //     onImageUpload: function(files) {
        //         uploadSummernoteImageFile(files[0], this);
        //     },
        //     opPaste: function(e) {
        //         let clipboardData = e.originalEvent.clipboardData;
        //         if(clipboardData && clipboardData.items && clipboardData.length) {
        //             let item = clipboardData.items[0];
        //             if(item.kind === 'file' && item.type.indexOf('image/') !== -1) {
        //                 e.preventDefault();
        //             }
        //         }
        //     }
        // }
    });
});

let postForm = function() {
    let contents = $('textarea[name="contents"]').html($('#sumernote').code());
}