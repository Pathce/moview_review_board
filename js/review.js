const btn_remove = document.querySelector('#btn_remove');
const btn_c_write = document.querySelector('#btn_c_write');
const comment_form = document.querySelector('#comment_form');
const txt_comment = document.querySelector('#txt_comment');

function onClickBtnRemove() {
    if(confirm("삭제하시겠습니까?")) {
        const num = document.querySelector('#r_seq_value').textContent;

        console.log(num)
        location.href="delete.php?r_seq=" + num;
    }
}

function addComment(event) {
    if(event.keyCode === 13) {
        comment_form.submit();
    }
}

btn_remove.addEventListener('click', onClickBtnRemove);
txt_comment.addEventListener('keydown', addComment);