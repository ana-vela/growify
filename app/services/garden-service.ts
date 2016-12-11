/**
 * Created by Daniel Eaton on 12/5/2016.
 */
import {Injectable} from "@angular/core";
import {Http} from "@angular/http";

import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Garden} from "../classes/garden";
import {Status} from "../classes/status";

@Injectable()
export class GardenService extends BaseService {
	constructor(http:Http) {
		super(http);
	}

	private url = "api/garden/";


	getGardenByGardenProfileId(gardenProfileId: number) : Observable<Garden[]> {
		return (this.http.get("api/garden/?gardenProfileId=19").map(this.extractData).catch(this.handleError));
	}

	postGarden(garden: Garden) : Observable<Status> {

		return(this.http.post(this.url, garden)
			.map(this.extractMessage)
			.catch(this.handleError));

	}

}

//this.http.get(this.url + "?gardenProfileId=" + gardenProfileId)