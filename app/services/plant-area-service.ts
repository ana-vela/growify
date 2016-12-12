import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Plant} from "../classes/plant";
import {PlantArea} from "../classes/plantArea";

@Injectable()
export class PlantAreaService extends BaseService {
	constructor(protected http: Http){
		super(http);
	}

	private plantAreaUrl = "api/plant-area/";

	// get plant area for a given plantId and currently logged-in user
	// many plants don't have this data, in which case it will return not found.
	getPlantAreaByPlantId( plantId: number){
		return(this.http.get(this.plantAreaUrl+"/?plantAreaPlantId="+plantId).map(this.extractData).catch(this.handleError));
	}

	getAllPlantAreas(): Observable<PlantArea[]>{
		return(this.http.get(this.plantAreaUrl).map(this.extractData).catch(this.handleError));
	}
}