<section class="weather-display">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<h3>Albuquerque Weather</h3>
				<ul>
					<li>Current Temp: {{albuquerqueWeather.currentTemperature}} degF</li>
					<li>Wind Speed: {{albuquerqueWeather.windSpeed}} mph</li>
					<li>Timestamp: {{albuquerqueWeather.timestamp}} s</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<h3>Week Forecast</h3>
			<div class="col-md-12">
				<h1><i class="wi wi-day-lightning"></i></h1>

					<ul>

					<li *ngFor="let day of dailyWeather">
						<ul>
							<li>Low: {{day.temperatureMin}} degF</li>
							<li>High: {{day.temperatureMax}} degF</li>
							<li>Wind Speed: {{day.windSpeed}} mph</li>
							<li>Timestamp: {{day.timestamp}}</li>
						</ul>

					</li>
					</ul>

			</div>
		</div>
		<h3>Burritos:</h3>
		<ul>
			<li *ngFor="let burrito of burritos">{{burrito}}</li>
		</ul>
	</div>
</section>
