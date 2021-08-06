const boardTabs = document.querySelector('.board_tabs');
const tab01 = boardTabs.querySelector('#tab01');
const tab02 = boardTabs.querySelector('#tab02');
const board01 = boardTabs.querySelector('.board01');
const board02 = boardTabs.querySelector('.board02');

const HIDDEN_CLASSNAME = 'hidden';

let chk = 1;

function onClickTab01(event) {
    if(chk !== 1){
        board02.classList.add(HIDDEN_CLASSNAME);
        board01.classList.remove(HIDDEN_CLASSNAME);
        chk = 1;
    }
}
function onClickTab02(event) {
    if(chk !== 2){
        board01.classList.add(HIDDEN_CLASSNAME);
        board02.classList.remove(HIDDEN_CLASSNAME);
        chk = 2;
    }
}

tab01.addEventListener('click', onClickTab01);
tab02.addEventListener('click', onClickTab02);