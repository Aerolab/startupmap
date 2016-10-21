<?php
	
	$countries = array();

	foreach($startups as $startup)
	{
		if( ! array_key_exists($startup->country->name, $countries))
			$countries[$startup->country->name] = 1;
		else
			$countries[$startup->country->name]++;
	}

?>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Country', 'Total Startups'],
			@foreach($countries as $countryName => $countryStartups)
			[ '{{ $countryName }}', {{ $countryStartups }} ],
			@endforeach
		]);

		var options = {
			title: 'Startups',
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

		var chart = new google.visualization.PieChart(document.getElementById('startupPieChartCountry'));
			chart.draw(data, options);
	}
</script>
<div id="startupPieChartCountry" style="margin-bottom:40px">
</div>