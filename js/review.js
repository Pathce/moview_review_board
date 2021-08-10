$(document).ready(function() {
    $('#btn_modify_co').click(function() {
        let obj = $(this).closest("#comment_list").find("#edit_comment");
        obj.dialog({
            modal: true,
            width: 650,
            height: 200,
            title: "댓글 수정"
        });
    });
})