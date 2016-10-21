<?php
	
	$startupsList = array();

	foreach($startups as $startup)
	{
		if(array_key_exists($startup->country_id, $startupsList))
			$startupsList[$startup->country_id]++;
		else
			$startupsList[$startup->country_id] = 1;
	}

?>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Country', 'Total Startups'],
			@foreach($startupsList as $iso => $startups)
			[ '{{ Country::where('iso', $iso)->first()->name }}', {{ $startups }} ],
			@endforeach
		]);

		var options = {
			title: 'Startups in ' . {{$tag->tag}},
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

		var chart = new google.visualization.PieChart(document.getElementById('startupPieChartTagCountry'));
			chart.draw(data, options);
	}
</script>
<div id="startupPieChartTagCountry" style="margin-bottom:40px">
</div>