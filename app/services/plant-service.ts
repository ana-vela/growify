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

		/*return(this.http.get(this.plantUrl+"?plantName="+plantName).map(this.extractData).catch(this.handleError));*/
		return(this.http.get("api/plant/?plantName=potato").map(this.extractData).catch(this.handleError));

	}

	getPlantsByLatinName(plantLatinName: string) : Observable<Plant[]>{
		return(this.http.get(this.plantUrl+"?plantLatinName="+plantLatinName).map(this.extractData).catch(this.handleError));
	}

	/* in this case, only one plant at most should be returned */
	getPlantByPlantId() : Observable<Plant> {
		return(this.http.get(this.plantUrl+"?plantId").map(this.extractData).catch(this.handleError));
	}

	getAllPlants(): Observable<Plant[]>{
		return(this.http.get(this.plantUrl).map(this.extractData).catch(this.handleError));
	}


}
