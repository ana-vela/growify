import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Plant} from "../classes/plant";
import {CompanionPlant} from "../classes/companionPlant";

@Injectable()
export class CompanionPlantService extends BaseService {
	constructor(protected http: Http){
		super(http);
	}

	private companionPlantUrl = "api/companion-plant/";

	getCompanionPlantsByName(plantName: string): Observable<CompanionPlant[]>{
		return( this.http.get(this.companionPlantUrl+"?companionPlantName="+plantName).map(this.extractData).catch(this.handleError));
	}

	getAllCompanionPlants(): Observable<CompanionPlant[]>{
		return(this.http.get(this.companionPlantUrl).map(this.extractData).catch(this.handleError));
	}
}