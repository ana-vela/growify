import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";

@Injectable()
export class LoginService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private loginUrl = "api/login/";

	private logoutUrl = "api/logout/";

	public isLoggedIn = false;// *ONLY* use for setting appropriate nav links, this
	// does not provide secure information (not adequate authentication)

	getLogout() : Observable<Status> {

		return(this.http.get(this.logoutUrl)
			.map(this.extractMessage)
			.catch(this.handleError));

	}



	postLogin(profile: Profile) : Observable<Status> {

		return(this.http.post(this.loginUrl, profile)
			.map(this.extractMessage)
			.catch(this.handleError));

	}




}