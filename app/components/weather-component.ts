import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {WeatherService} from "../services/weather-service";
import {ProfileService} from "../services/profile-service";

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

	currentWeather: Weather = new Weather(0, 0, 0, 0, 0, 0, "", "", "");
	//albuquerqueWeather: Weather = new Weather(0, 0, 0, 0, 0, 0, "", "", "");
	dailyWeather: Weather[] = [];
	status: Status = null;

	burritos: String[] = ["breakfast", "carne adovada", "frijoles"];

	profile: Profile = new Profile(0, "old", "old data", "old", "old data"); // initialize
	testProfile: Profile = new Profile(23, "this", "is", "a", "test");

	constructor(private weatherService: WeatherService,private profileService: ProfileService, private route: ActivatedRoute){}


	ngOnInit() : void {
// get current and daily weather
					this.weatherService.getCurrentWeather().subscribe(weather=>this.currentWeather = weather);
					this.weatherService.getWeekForecastWeather().subscribe(weather=>this.dailyWeather=weather);
		}


}