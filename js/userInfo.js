const userChart = document.querySelector('.user_chart');
const chartTabs = userChart.querySelector('.chart_tabs');
const chartContent = userChart.querySelector('.chart_content');
const tab02 = chartTabs.querySelector('#tab02');
const tab03 = chartTabs.querySelector('#tab03');
const chart02 = chartContent.querySelector('.chart02');
const chart03 = chartContent.querySelector('.chart03');

const HIDDEN_CLASSNAME = 'hidden';

let chk = 1;

function onClickTab02(event){
    console.log("clicked2");
    if (chk !== 2) {
        chart03.classList.add(HIDDEN_CLASSNAME);
        chart02.classList.remove(HIDDEN_CLASSNAME);
        chk = 2;
    }
}
function onClickTab03(event){
    console.log("clicked3");
    if (chk !== 3) {
        chart02.classList.add(HIDDEN_CLASSNAME);
        chart03.classList.remove(HIDDEN_CLASSNAME);
        chk = 3;
    }
}

tab02.addEventListener('click', onClickTab02);
tab03.addEventListener('click', onClickTab03);