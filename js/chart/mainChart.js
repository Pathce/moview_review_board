let date_data = document.querySelector('#date_data').textContent;

date_data = Object.entries(JSON.parse(date_data));

let date_list = [];
let year = "";
let month = "";
let day = "";

for(let i = 0; i < 5; i++) {
    date_list[i] = new Date();
    date_list[i].setDate(date_list[i].getDate() - i);
    year = date_list[i].getFullYear();
    month = ('0' + (date_list[i].getMonth() + 1)).slice(-2);
    day = ('0' + date_list[i].getDate()).slice(-2);
    date_list[i] = year + '-' + month  + '-' + day;
}

let d_data = [];
let genre_date_data = [];
let genre_list = [];
let genre_rank = [];
let genre_obj = {};

for(let element of date_data) {
    if(date_list.includes(element[1]['date'])) {
        element[1]['cnt'] *= 1;
        d_data.push(element[1]);
        if(!(element[1]['genre'] in genre_obj)) {
            genre_obj[element[1]['genre']] = element[1]['cnt'];
        } else {
            genre_obj[element[1]['genre']] += element[1]['cnt'];
        }
    }
}
for(let g in genre_obj) {
    genre_list.push([g, genre_obj[g]]);
}
genre_list.sort(function(a, b) {
    return b[1] - a[1];
})
if(genre_list.length > 5){
    genre_list = genre_list.slice(0, 5);
}
for(let element of genre_list) {
    genre_rank.push(element[0]);
    genre_date_data[element[0]] = {};
    for(let value of date_list) {
        genre_date_data[element[0]][value] = 0;
    }
}
for(let element of d_data) {
    switch(element['genre']) {
        case genre_rank[0]: genre_date_data[element['genre']][element['date']] = element['cnt']; break;
        case genre_rank[1]: genre_date_data[element['genre']][element['date']] = element['cnt']; break;
        case genre_rank[2]: genre_date_data[element['genre']][element['date']] = element['cnt']; break;
        case genre_rank[3]: genre_date_data[element['genre']][element['date']] = element['cnt']; break;
        case genre_rank[4]: genre_date_data[element['genre']][element['date']] = element['cnt']; break;
    }
}
let chart_data = [];
for(let i in genre_date_data) {
    chart_data[i] = [];
    idx = 0;
    for(let j in genre_date_data[i]) {
        chart_data[i][idx++] = {date: new Date(j), value: genre_date_data[i][j]}
    }
}

// highchart____________________________________________________________________________________________________________

console.log(chart_data[genre_rank[0]]);
console.log(genre_date_data);
let g_data = Array();
let g_index = 0;
let start_date = date_list[0].replace(/[^0-9]/g,'');

for(let element in genre_date_data) {
    console.log(element);
    g_data.push({name: element, data: []});
    g_data[g_index++].data = Object.values(genre_date_data[element]).reverse();
}

console.log(g_data);

Highcharts.chart('review_date_chart', {
    title: {
        text: '장르별 리뷰'
    },
    subtitle: {
        text: ''
    },
    yAxis: {
        title: {
            text: ' '
        }
    },
    xAxis: {
        title: {
            text: '날짜'
        },
        categories: date_list
    },
    /* 범례를 우측 세로로 정렬 */
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
    series: g_data,
});