const boardTabs = document.querySelector('.board_tabs');

const option_search = document.querySelector('#option_search');
const input_search = document.querySelector('#input_search');
const btn_search = document.querySelector('#btn_search');

function onClickBtnSearch() {
    link = 'review_board.php?option=' + option_search.value + '&&search=' + input_search.value;
    location.href = link;
}

btn_search.addEventListener('click', onClickBtnSearch);