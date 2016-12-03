<section class="weather-display">
	<div class="container text-center">
		<div class="row">

			<div class="col-md-4 current-weather text-center">
				<div class="row ">
					<div class="col-xs-12">
						<h3>Current weather, 87106</h3>
						<h3 >{{albuquerqueWeather.date}}</h3>
						<h1><i [ngClass]="['wi', albuquerqueWeather.icon]"></i></h1>

						<div class="row">
							<div class="col-xs-6">
								<h3>{{albuquerqueWeather.currentTemperature}} &deg;F</h3>
							</div>
							<div class="col-xs-6">
								<h3>{{albuquerqueWeather.windSpeed}} mph</h3>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- close current-weather -->


			<div class="col-md-8 week-forecast text-justify">
				<table class="table">
					<tr  *ngFor="let dayWeather of dailyWeather">
						<td>{{dayWeather.date}}</td>
						<td><h3><i [ngClass]="['wi', dayWeather.icon]"></i></h3></td>
						<td class="low">{{dayWeather.temperatureMin}}&deg;F</td>
						<td class="high">{{dayWeather.temperatureMax}} &deg;F</td>
						<td>{{dayWeather.windSpeed}} mph</td>
					</tr>
				</table>
			</div>
		</div> <!-- close week-forecast-->
	</div>
</section>
