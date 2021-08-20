let review_data = document.querySelector('#review_data').textContent;
let comment_data = document.querySelector('#comment_data').textContent;
review_data = review_data.replaceAll('["', '');
review_data = review_data.replaceAll('"]', '');
review_data = Object.entries(JSON.parse(review_data));
comment_data = comment_data.replaceAll('["', '');
comment_data = comment_data.replaceAll('"]', '');
comment_data = Object.entries(JSON.parse(comment_data));

let r_data = [];
for (let element of review_data) r_data.push({name: element[0], value: element[1]});
if(r_data.length > 5) r_data = r_data.slice(0, 5);

let c_data = [];
for (let element of comment_data) c_data.push({name: element[0], value: element[1]});
if(c_data.length > 5) c_data = c_data.slice(0, 5);

const width = 800;
const height = 400;
const margin = {top: 40, left: 40, bottom: 40, right: 40};

// review_________________________________________________________________________________
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

const r_svg = d3.select('#reviewChart').append('svg').style('width', width).style('height', height);

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

// comment________________________________________________________________________________
const c_x = d3.scaleBand()
    .domain(c_data.map(d => d.name))
    .range([margin.left, width - margin.right])
    .padding(0.2);

const c_y = d3.scaleLinear()
    .domain([0, d3.max(c_data, d => d.value)]).nice()
    .range([height - margin.bottom, margin.top]);

const cxAxis = g => g
    .attr('transform', `translate(0, ${height - margin.bottom})`)
    .call(d3.axisBottom(c_x)
        .tickSizeOuter(0));

const cyAxis = g => g
    .attr('transform', `translate(${margin.left}, 0)`)
    .call(d3.axisLeft(c_y))
    .call(g => g.select('.domain').remove());

const c_svg = d3.select('#commentChart').append('svg').style('width', width).style('height', height);

c_svg.append('g').call(cxAxis);
c_svg.append('g').call(cyAxis);
c_svg.append('g')
    .attr('fill', 'steelblue')
    .selectAll('rect').data(c_data).enter().append('rect')
    .attr('x', d => c_x(d.name))
    .attr('y', d => c_y(d.value))
    .attr('height', d => c_y(0) - c_y(d.value))
    .attr('width', c_x.bandwidth());

c_svg.node();