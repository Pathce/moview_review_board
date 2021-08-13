let mrank = document.querySelector('#movie_rec_rank').textContent;
console.log(mrank);
mrank = Object.entries(JSON.parse(mrank));
let movie_rank = [];
for(let element of mrank) {
    movie_rank.push(element[1]);
}

let r_data = [];
for (let element of movie_rank) {
    console.log(element);
    r_data.push({name: element['title'], value: element['r_avg']*1});
}
if(r_data.length > 5) r_data = r_data.slice(0, 5);

console.log(r_data);

const width = 800;
const height = 400;
const margin = {top: 40, left: 40, bottom: 40, right: 40};

// rec_rank_____________________________________________________________________________________________________________
const r_x = d3.scaleBand()
    .domain(r_data.map(d => d.name))
    .range([margin.left, width - margin.right])
    .padding(0.2);

const r_y = d3.scaleLinear()
    .domain([0, d3.max(r_data, d => d.value)]).nice()
    .range([height - margin.bottom, margin.top]);

const rxAxis = g => g
    .attr('transform', `translate(0, ${height - margin.bottom})`)
    .call(d3.axisBottom(r_x)
        .tickSizeOuter(0));

const ryAxis = g => g
    .attr('transform', `translate(${margin.left}, 0)`)
    .call(d3.axisLeft(r_y))
    .call(g => g.select('.domain').remove());

const r_svg = d3.select('#rec_rank_chart').append('svg').style('width', width).style('height', height);

r_svg.append('g').call(rxAxis);
r_svg.append('g').call(ryAxis);
r_svg.append('g')
    .attr('fill', 'steelblue')
    .selectAll('rect').data(r_data).enter().append('rect')
    .attr('x', d => r_x(d.name))
    .attr('y', d => r_y(d.value))
    .attr('height', d => r_y(0) - r_y(d.value))
    .attr('width', r_x.bandwidth());

r_svg.node();

// high_chart___________________________________________________________________________________________________________
Highcharts.chart('container', {
    title: {
        text: '차트 타이틀'
    },
    subtitle: {
        text: '차트 서브타이틀'
    },
    yAxis: {
        title: {
            text: 'y축 타이틀'
        }
    },
    xAxis: {
        title: {
            text: 'x축 타이틀'
        }
    },
    /* 범례를 우측 세로로 정렬 */
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
    series: [{
        name: '범례 1',
        data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
    }, {
        name: '범례 2',
        data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
    }, {
        name: '범례 3',
        data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
    }, {
        name: '범례 4',
        /* series.data가 null일 경우 라인이 도식되지 않음 */
        data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
    }, {
        name: '범례 5',
        data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
    }],
});
