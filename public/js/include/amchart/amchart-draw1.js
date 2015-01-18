
//AJAX CALL FOR CHARTS GO HERE
var url = "http://advancedairadmin.com/user/getchart";
$.ajax({
  dataType: "html",
  url: url,
  success: function(data){
	var chart;
	var chartData = eval(data);
AmCharts.ready(function() {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "date";
    chart.marginRight = 0;
    chart.marginTop = 0;    
    chart.autoMarginOffset = 0;
    // the following two lines makes chart 3D
    chart.depth3D = 20;
    chart.angle = 30;

    // AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.labelRotation = 90;
    categoryAxis.dashLength = 5;
    categoryAxis.gridPosition = "start";

    // value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.title = "Sales";
    valueAxis.dashLength = 5;
    chart.addValueAxis(valueAxis);
    // GRAPH            
    var graph = new AmCharts.AmGraph();
    graph.valueField = "sales";
    graph.colorField = "color";
    graph.balloonText = "[[category]]: $[[value]]";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 1;
    chart.addGraph(graph);
    // WRITE
    chart.write("chartdiv");
});
  
  }
});



