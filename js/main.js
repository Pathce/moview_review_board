const reviewContainer = document.querySelector(".review_container");
const reviewTabs = reviewContainer.querySelector('.review_tabs');
const tabContent = reviewContainer.querySelector('.tab_content');
const tab01 = reviewTabs.querySelector('#tab01');
const tab02 = reviewTabs.querySelector('#tab02');
const tabContent01 = tabContent.querySelector('#tab-1');
const tabContent02 = tabContent.querySelector('#tab-2');

const HIDDEN_CLASSNAME = "hidden";

chk = 1;

function onClickTab1(event) {
    console.log("Clicked 01");
    if (chk === 2){
        tabContent02.classList.add(HIDDEN_CLASSNAME);
        tabContent01.classList.remove(HIDDEN_CLASSNAME);
        chk--;
    }
}

function onClickTab2(event) {
    console.log("Clicked 02");
    if (chk === 1){
        tabContent01.classList.add(HIDDEN_CLASSNAME);
        tabContent02.classList.remove(HIDDEN_CLASSNAME);
        chk++;
    }
}

tab01.addEventListener("click", onClickTab1);
tab02.addEventListener("click", onClickTab2);