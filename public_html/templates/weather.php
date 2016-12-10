<section class="weather-display">
	<div class="container text-center">
		<div class="row">

			<div class="col-md-4 col-md-offset-1 current-weather text-center">
				<div class="row ">
					<div class="col-xs-12">
						<h3>Zipcode {{profile.zipcode}}</h3>
						<h3>Current weather, 87106</h3>
						<h3 >{{albuquerqueWeather.date}}</h3>
						<h1><i [ngClass]="['wi', albuquerqueWeather.icon]"></i></h1>

						<div class="row">
							<div class="col-xs-6">
								<h3>{{albuquerqueWeather.currentTemperature|number:'.0-0'}} &deg;F</h3>
							</div>
							<div class="col-xs-6">
								<h3>{{albuquerqueWeather.windSpeed|number:'.0-1'}} mph</h3>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- close current-weather -->


			<div class="col-md-6 week-forecast text-justify">
				<table class="table">
					<tr  *ngFor="let dayWeather of dailyWeather">
						<td class="week-forecast-icon"><i [ngClass]="['wi', dayWeather.icon]"></i></td>
						<td>{{dayWeather.date}}</td>
						<td class="low">{{dayWeather.temperatureMin|number:'.0-0'}}&deg;F</td>
						<td class="high">{{dayWeather.temperatureMax|number:'.0-0'}} &deg;F</td>
						<td>{{dayWeather.windSpeed|number:'.0-1'}} mph</td>
					</tr>
				</table>
			</div>
		</div> <!-- close week-forecast-->
	</div>
</section>
