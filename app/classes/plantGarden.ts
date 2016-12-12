import {Garden} from "../classes/garden";
import {Plant} from "../classes/plant";


/**
 * Created by Daniel Eaton on 12/10/2016.
 */
export class PlantGarden{
	// progress is percent completion of growing days to expected harvest date.
	// date planted in milliseconds since beg. of time
	constructor(public garden:Garden, public plant:Plant, public datePlantedMillis: number, public progress: number = null){
	}
}