import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Plant} from "../classes/plant";

@Injectable()
export class PlantService extends BaseService {
	constructor(protected http: Http){
		super(http);
	}

	private plantUrl = "api/plant/";

	getPlantsByName(plantName: string) : Observable<Plant[]>{

		return(this.http.get(this.plantUrl+"?plantName="+plantName).map(this.extractData).catch(this.handleError));

	}
	/* TODO implement
	getPlantsByLatinName() : Observable<Plant[]>{

	}

	getPlantByPlantId() : Observable<Plant> {

	}*/


}