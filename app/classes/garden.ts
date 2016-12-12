/**
 * Created by Daniel Eaton on 12/5/2016.
 */

export class Garden{
	constructor(public gardenProfileId:number, public gardenDatePlanted:string, public gardenPlantId:number){
	}
	/* why am I not able to access these methods? */
	/*
	public getDatePlanted(): Date{
		return (new Date(Number.parseInt(this.gardenDatePlanted)));

	}

	public getDatePlantedMillis(): number{
		return Number.parseInt(this.gardenDatePlanted);
	}*/

	/*public getElapsedDays(): number{
		let currentTime = new Date();
		return (currentTime.getMilliseconds()-Number.parseInt(this.gardenDatePlanted))/(1000*60*60*24);

	}*/
}