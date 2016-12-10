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

	profile: Profile = new Profile(0, "", "", "", "");
	//status: Status = null;

	//isLoggedIn: boolean = false;

	postLogin(profile: Profile) : Observable<Status> {

		return(this.http.post(this.loginUrl, profile)
			.map(this.extractMessage)
			.catch(this.handleError));

	}



}