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