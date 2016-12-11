import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";

@Injectable()
export class ActivationService extends BaseService {
	constructor(protected http: Http){
		super(http);
	}

	private activationUrl = "api/activation/";
	/* get profile for already-logged in user
	 * based on session */

	getActivation(): Observable<Status>{
		return(this.http.get(this.activationUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}
}
