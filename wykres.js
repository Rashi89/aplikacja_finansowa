google.load("visualization", "1", {
  packages: ["corechart"]
});
google.setOnLoadCallback(initChart);

$(window).on("throttledresize", function(event) {
  initChart();
});

function initChart() {
  var options = {
    legend: 'none',
    width: '100%',
    height: '100%',
    pieSliceText: 'percentage',
    colors: ['#0598d8', '#f97263'],
    chartArea: {
      left: "3%",
      top: "3%",
      height: "94%",
      width: "94%"
    }
  };

  var data = google.visualization.arrayToDataTable([
    ['Gender', 'Overall'],
    ['M', 110],
    ['F', 20]
  ]);
  drawChart(data, options)
}

function drawChart(data, options) {
  var chart = new google.visualization.PieChart(document.getElementById('chart'));
  chart.draw(data, options);
}