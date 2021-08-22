const reviewContainer = document.querySelector(".review_container");
const reviewTabs = reviewContainer.querySelector('.review_tabs');
const tabContent = reviewContainer.querySelector('.tab_content');
const tabContent01 = tabContent.querySelector('.tab-1');
const tabContent02 = tabContent.querySelector('.tab-2');

const tab1 = reviewTabs.querySelector('#tab001');
const tab2 = reviewTabs.querySelector('#tab002');
const tab1Eff = tab1.querySelector('#eff1');
const tab2Eff = tab2.querySelector('#eff2');

let imgs = document.querySelectorAll('img');

const btn_search = document.querySelector('#btn_search');
const input_search = document.querySelector('#input_search');

const HIDDEN_CLASSNAME = "hidden";

let chk = 1;

function onClickTab1() {
    if (chk === 2) {
        tab1.classList.remove('non_clicked');
        tab1.classList.add('clicked');
        tab1Eff.classList.remove('eff-2');
        tab1Eff.classList.add('eff-1');
        tab2.classList.remove('clicked');
        tab2.classList.add('non_clicked');
        tab2Eff.classList.remove('eff-1');
        tab2Eff.classList.add('eff-2');
        tabContent02.classList.add(HIDDEN_CLASSNAME);
        tabContent01.classList.remove(HIDDEN_CLASSNAME);
        chk--;
    }
}
function onClickTab2() {
    if (chk === 1) {
        tab2.classList.remove('non_clicked');
        tab2.classList.add('clicked');
        tab2Eff.classList.remove('eff-2');
        tab2Eff.classList.add('eff-1');
        tab1.classList.remove('clicked');
        tab1.classList.add('non_clicked');
        tab1Eff.classList.remove('eff-1');
        tab1Eff.classList.add('eff-2');
        tabContent01.classList.add(HIDDEN_CLASSNAME);
        tabContent02.classList.remove(HIDDEN_CLASSNAME);
        chk++;
    }
}

function onClickImg(event) {
    let alt = event.target.alt;
    let link = 'review_board.php?option=영화' + '&&search=' + `${alt}`;
    location.href = link;
}

function onClickBtnSearch() {
    let link = 'review_board.php?option=' + option_search.value + '&&search=' + input_search.value;
    location.href = link;
}
function onSearch(event) {
    if(event.keyCode === 13) {
        let link = 'review_board.php?option=' + option_search.value + '&&search=' + input_search.value;
        location.href = link;
    }
}

tab1.addEventListener('click', onClickTab1);
tab2.addEventListener('click', onClickTab2);
btn_search.addEventListener('click', onClickBtnSearch);
input_search.addEventListener('keydown', onSearch);

imgs.forEach(function(img) {
    img.addEventListener('click', onClickImg);
});