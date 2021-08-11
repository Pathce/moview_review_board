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

console.log(genre_date_data);
console.log(genre_rank[0]);
console.log(genre_date_data[genre_rank[0]]);

let chart_data = [];

for(let i in genre_date_data) {
    chart_data[i] = [];
    idx = 0;
    for(let j in genre_date_data[i]) {
        chart_data[i][idx++] = {date: new Date(j), value: genre_date_data[i][j]}
    }
}

console.log(chart_data);
console.log(chart_data[genre_rank[0]]);
//________________________________________________________________________
const width = 800;
const height = 500;
const margin = {top: 40, right: 40, bottom: 40, left: 40};
const data = chart_data[genre_rank[0]];

const x = d3.scaleTime()
    .domain(d3.extent(data, d => d.date))
    .range([margin.left, width - margin.right]);

const y = d3.scaleLinear()
    .domain([0, d3.max(data, d => d.value)]).nice()
    .range([height - margin.bottom, margin.top]);

const svg = d3.select('#date_line_graph').append('svg').style('width', width).style('height', height);

function createChart(data, i) {
        const xAxis = g => g
        .attr("transform", `translate(0,${height - margin.bottom})`)
        .call(d3.axisBottom(x).ticks(width / 90).tickSizeOuter(0));

    const yAxis = g => g
        .attr("transform", `translate(${margin.left},0)`)
        .call(d3.axisLeft(y))
        .call(g => g.select(".domain").remove())
        .call(g => {
            return g.select(".tick:last-of-type text").clone()
                .attr("x", 3)
                .attr("text-anchor", "start")
                .attr("font-weight", "bold")
                .attr("font-size", '20px')
                .text(i)
        });

    const line = d3.line()
        .defined(d => !isNaN(d.value))
        .x(d => x(d.date))
        .y(d => y(d.value));

    svg.append("path")
        .datum(data)
        .attr("fill", "none")
        .attr("stroke", "steelblue")
        .attr("stroke-width", 1)
        .attr("stroke-linejoin", "round")
        .attr("stroke-linecap", "round")
        .attr("d", line);
    svg.append('g').call(xAxis);
    svg.append('g').call(yAxis);
    return svg;
}

for(let i = 0; i < genre_rank.length; i++) {
    createChart(chart_data[genre_rank[i]]);
}