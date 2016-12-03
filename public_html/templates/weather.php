<section class="weather-display">
	<div class="container">
		<div class="row">

			<div class="col-md-4 current-weather">
				<div class="row ">
					<div class="col-xs-12">
						<h3>Current weather, 87106</h3>
						<h3>{{albuquerqueWeather.date}}</h3>
						<h1><i [ngClass]="['wi', albuquerqueWeather.icon]"></i></h1>

						<div class="row">
							<div class="col-xs-6">
								{{albuquerqueWeather.currentTemperature}} &deg;F
							</div>
							<div class="col-xs-6">
								{{albuquerqueWeather.windSpeed}} mph
							</div>
						</div>
					</div>
				</div>
			</div> <!-- close current-weather -->


			<div class="col-md-8 week-forecast">
				<div class="row " *ngFor="let day of dailyWeather">
					<div class="col-xs-12">
						<span>{{day.date}}</span><i [ngClass]="['wi', day.icon]"></i><span class="low">{{day.temperatureMin}}&deg;F</span><span class="high">{{day.temperatureMax}} &deg;F</span><span>{{day.windSpeed}} mph</span>
					</div>
				</div>
			</div>
		</div> <!-- close week-forecast-->
	</div>
</section>
