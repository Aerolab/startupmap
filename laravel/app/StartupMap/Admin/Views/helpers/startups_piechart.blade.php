<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Category', 'Total Startups'],
			@foreach(Category::all() as $category)
			[ '{{ $category->name }}', {{ $category->startups()->count() }} ],
			@endforeach
		]);

		var options = {
			title: 'Startups in our map',
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
          		height: "70%"
          	}
		};

		var chart = new google.visualization.PieChart(document.getElementById('startupPieChart'));
			chart.draw(data, options);
	}
</script>
<div id="startupPieChart">
</div>