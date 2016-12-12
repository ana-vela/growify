import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Weather} from "../classes/weather";
import {Status} from "../classes/status";

@Injectable()
export class WeatherService extends BaseService {
	constructor(protected http: Http){
		super(http);
	}

	private weatherUrl = "api/weather/";



	// add exclude=["minutely", "hourly"]
	getCurrentWeather():Observable<Weather>{
		let current = true;
		return(this.http.get(this.weatherUrl +"?current="+ current)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// add get week forecast for zip code
	getWeekForecastWeather():Observable<Weather[]>{
		let current = false;
		return(this.http.get(this.weatherUrl +"?current="+ current)
			.map(this.extractData)
			.catch(this.handleError));
	}

}