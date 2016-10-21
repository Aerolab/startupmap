<?php
	
	$tagList = array();

	foreach($tags as $tag)
		$tagList[$tag->tag] = count($tag->startups());

?>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Tag', 'Total Startups'],
			@foreach($tagList as $tag => $startups)
			[ '{{ $tag }}', {{ $startups }} ],
			@endforeach
		]);

		var options = {
			title: 'Startups by tag',
          	legend: {
          		alignment: 'center',
          		position: 'left'
          	},
			/*titleTextStyle: {
				fontSize: 20
			},
          	pieHole: 0.5,
          	chartArea: {
          		width: "70%",
          		height: "70%"
          	}*/
		};

		var chart = new google.visualization.BarChart(document.getElementById('startupPieChartTag'));
			chart.draw(data, options);
	}
</script>
<div id="startupPieChartTag" style="height:1000px">
</div>