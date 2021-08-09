const reviewContainer = document.querySelector(".review_container");
const reviewTabs = reviewContainer.querySelector('.review_tabs');
const tabContent = reviewContainer.querySelector('.tab_content');
const tabContent01 = tabContent.querySelector('.tab-1');
const tabContent02 = tabContent.querySelector('.tab-2');

const tab1 = reviewTabs.querySelector('#tab001');
const tab2 = reviewTabs.querySelector('#tab002');
const tab1Eff = tab1.querySelector('#eff1');
const tab2Eff = tab2.querySelector('#eff2');

const poster_list = document.querySelector('#movie_poster_list');
let imgs = document.querySelectorAll('img');

const btn_search = document.querySelector('#btn_search');

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
    console.log(event.target.id);
    let link = "";
    switch (event.target.id) {
        case 'img_m1': link = 'review_board.php?option="영화"' + '&&search=' + "모가디슈"; break;
        case 'img_m2': link = 'review_board.php?option="영화"' + '&&search=' + "더 수어사이드 스쿼드"; break;
        case 'img_m3': link = 'review_board.php?option="영화"' + '&&search=' + "방법:재차의"; break;
        case 'img_m4': link = 'review_board.php?option="영화"' + '&&search=' + "보스 베이비 2"; break;
        case 'img_m5': link = 'review_board.php?option="영화"' + '&&search=' + "정글 크루즈"; break;
        case 'img_m6': link = 'review_board.php?option="영화"' + '&&search=' + "더 그레이트 샤크"; break;
        case 'img_m7': link = 'review_board.php?option="영화"' + '&&search=' + "그린나이트"; break;
        case 'img_m8': link = 'review_board.php?option="영화"' + '&&search=' + "도라에몽 진구의 신공룡"; break;
        case 'img_m9': link = 'review_board.php?option="영화"' + '&&search=' + "블랙 위도우"; break;
        case 'img_m10': link = 'review_board.php?option="영화"' + '&&search=' + "피닉스"; break;
    }
    location.href = link;
}

function onClickBtnSearch() {
    let link = 'review_board.php?option=' + option_search.value + '&&search=' + input_search.value;
    location.href = link;
}

tab1.addEventListener('click', onClickTab1);
tab2.addEventListener('click', onClickTab2);
btn_search.addEventListener('click', onClickBtnSearch);

imgs.forEach(function(img) {
    img.addEventListener('click', onClickImg);
});