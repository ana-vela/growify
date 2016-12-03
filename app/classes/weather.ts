export class Weather {
	constructor(public currentTemperature: number, public temperatureMin: number, public temperatureMax: number, public windSpeed: number,public humidity: number, public precipitationProbability: number, public timestamp: number, public summary: string, public icon: string){}

	getIconClass() {
		let classes = {
			wi-snow: boolean (this.icon == "snow"),
			wi-rain: (this.icon == "rain"),
			wi-day-sunny: this.icon == "clear-day",
			wi-night-clear: this.icon == "clear-night",
			wi-sleet: this.icon == "sleet",
			wi-wind: this.icon == "wi-strong-wind",
			wi-fog: this.icon == "fog",
			wi-cloudy: this.icon == "cloudy",
			wi-partly-cloudy: this.icon == "partly-cloudy-day",
			wi-partly-cloudy: this.icon == "partly-cloudy-night",
			wi-hail: this.icon == "hail",
			wi-default: this.icon == null
		};
		return classes;

	}

}