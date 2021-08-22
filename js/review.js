const btn_remove = document.querySelector('#btn_remove');
const btn_c_write = document.querySelector('#btn_c_write');
const comment_form = document.querySelector('#comment_form');
const txt_comment = document.querySelector('#txt_comment');
const comment_list = document.querySelector('#comment_list');
let btn_c_delete = comment_list.querySelectorAll('#co_delete');

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

function onClickBtnCoDelete(event) {
    url = event.target.className;
    if(confirm("삭제하시겠습니까?")) {
        location.href = './delete_co.php?c_seq=' + url;
    }
}

btn_remove.addEventListener('click', onClickBtnRemove);
txt_comment.addEventListener('keydown', addComment);

btn_c_delete.forEach(function(btn) {
    btn.addEventListener('click', onClickBtnCoDelete);
})