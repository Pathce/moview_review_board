const btn_remove = document.querySelector('#btn_remove');

function onClickBtnRemove() {
    if(confirm("삭제하시겠습니까?")) {
        const num = document.querySelector('#r_seq_value').textContent;

        console.log(num)
        location.href="delete.php?r_seq=" + num;
    }
}

btn_remove.addEventListener('click', onClickBtnRemove);