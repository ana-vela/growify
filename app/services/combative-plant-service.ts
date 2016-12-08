import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Plant} from "../classes/plant";
import {CombativePlant} from "../classes/combativePlant";

@Injectable()
export class CombativePlantService extends BaseService {
	constructor(protected http: Http){
		super(http);
	}

	private combativePlantUrl = "api/combativePlant/";

	getCombativePlantsByName(plantName: string): Observable<CombativePlant[]>{
		return( this.http.get(this.combativePlantUrl+"?combativePlantName="+plantName).map(this.extractData).catch(this.handleError));
	}

	getAllCombativePlants(): Observable<CombativePlant[]>{
		return(this.http.get(this.combativePlantUrl).map(this.extractData).catch(this.handleError));
	}
}