import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {WeatherService} from "../services/weather-service";
import {LoginService} from "../services/login-service";

import {Observable} from "rxjs/Observable"
import {Weather} from "../classes/weather";
import {Profile} from "../classes/profile";

import {Status} from "../classes/status";

@Component({
	/*moduleId: module.id,*/
	templateUrl: "./templates/weather.php",
	selector: "weather-component",
	/*styles: [require('../css/weather-icons.css')]*/
	/*styleUrls: ['/app/css/weather-icons.css']*/
})

export class WeatherComponent implements OnInit {
 // need @ViewChild ??
	//deleted: boolean = false;
	currentWeather: Weather = new Weather(0, 0, 0, 0, 0, 0, "", "", "");
	albuquerqueWeather: Weather = new Weather(0, 0, 0, 0, 0, 0, "", "", "");
	dailyWeather: Weather[] = [];
	status: Status = null;

	burritos: String[] = ["breakfast", "carne adovada", "frijoles"];



	constructor(private weatherService: WeatherService,private loginService: LoginService, private route: ActivatedRoute){}

	ngOnInit() : void {
		// call getCurrentWeatherAlbuquerque() method of the weather service.
		// this returns an observable, which we subscribe to
		// in the subscribe method, we pass a function(lambda) to be executed
		// when the data is available

		let profile: Profile = this.loginService.profile;
		let zipcode = "87106";
		// get current and daily weather

		this.weatherService.getCurrentWeatherAlbuquerque().subscribe(weather=>this.albuquerqueWeather=weather);

		this.weatherService.getCurrentWeatherByZipcode(zipcode).subscribe(weather=>this.currentWeather = weather);

		this.weatherService.getWeekForecastWeatherByZipcode(zipcode).subscribe(weather=>this.dailyWeather=weather);

		/**
		this.route.params.forEach((params: Params)=> {

			let zipcode = params["zipcode"];


			// get current and daily weather

			this.weatherService.getCurrentWeatherAlbuquerque().subscribe(weather=>this.albuquerqueWeather=weather);

			this.weatherService.getCurrentWeatherByZipcode(zipcode).subscribe(weather=>this.currentWeather = weather);

			this.weatherService.getWeekForecastWeatherByZipcode(zipcode).subscribe(weather=>this.dailyWeather.concat(weather));

		});*/

	}





}