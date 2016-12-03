export class Weather {
	constructor(public currentTemperature: number, public temperatureMin: number, public temperatureMax: number, public windSpeed: number,public humidity: number, public precipitationProbability: number, public timestamp: number, public summary: string, public icon: string){}


	/*public classes = {

	'wi-snow': (this.icon === "snow"),
	'wi-rain': (this.icon === "rain"),
	'wi-day-sunny': this.icon === "clear-day",
	'wi-night-clear': this.icon === "clear-night",
	'wi-sleet': this.icon === "sleet",
	'wi-wind': this.icon === "wi-strong-wind",
	'wi-fog': this.icon === "fog",
	'wi-cloudy': this.icon === "cloudy",
	'wi-partly-cloudy': (this.icon === "partly-cloudy-day" || this.icon === "partly-cloudy-night"),
	'wi-hail': this.icon === "hail",
	'wi-thermometer': (this.icon === null || this.icon=="thermometer")
	};*/

	/*
	public getWiIcon(): string{
		if(this.icon === "snow"){
			return "wi wi-snow";
		} else if (this.icon === "rain"){
			return "wi wi-rain";
		} else if (this.icon === "clear-day") {
			return "wi wi-day-sunny";
		} else if (this.icon === "clear-night") {
			return "wi wi-night-clear";
		} else if (this.icon === "sleet") {
			return "wi wi-sleet";
		} else if (this.icon ===)
	}*/

}