<section class="login">
	<div class="container">
		<div class="jumbotron text-center">
			<h1>Garden</h1>
			<p class="lead">Add some plants to your garden list!</p>
		</div>
	</div>
</section>
<section class="weather-display">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<ul>
					<li>Min Temp: {{dailyWeather.temperatureMin}} degF</li>
					<li>Max Temp: {{dailyWeather.temperatureMax}} degF</li>
					<li>Wind Speed: {{dailyWeather.windSpeed}} mph</li>
					<li>Timestamp: {{dailyWeather.timestamp}} s</li>
				</ul>
			</div>
		</div>
	</div>
</section>
