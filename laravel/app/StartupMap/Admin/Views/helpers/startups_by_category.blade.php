<?php
	
	$categories = array();

	foreach($startups as $startup)
	{
		if( ! array_key_exists($startup->category->name, $categories))
			$categories[$startup->category->name] = 1;
		else
			$categories[$startup->category->name]++;
	}

?>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Category', 'Total Startups'],
			@foreach($categories as $catName => $catStartups)
			[ '{{ $catName }}', {{ $catStartups }} ],
			@endforeach
		]);

		var options = {
			title: 'Startups by category',
			titleTextStyle: {
				fontSize: 20
			},
          	pieHole: 0.5,
          	legend: {
          		alignment: 'center',
          		position: 'left'
          	},
          	chartArea: {
          		width: "70%",
          		height: "100%"
          	}
		};

		var chart = new google.visualization.PieChart(document.getElementById('startupPieChartCategory'));
			chart.draw(data, options);
	}
</script>
<div id="startupPieChartCategory" style="margin-bottom:40px">
</div>