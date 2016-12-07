import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base-service";
import {Profile} from "../classes/profile";

@Injectable()
export class ProfileService extends BaseService {
	constructor(protected http: Http){
		super(http);
	}

	private profileUrl = "api/profile/";

	getProfileByUsername(profileUsername: string) : Observable<Profile>{

	return(this.http.get(this.profileUrl+"?profileUserInput="+profileUsername).map(this.extractData).catch(this.handleError));

}

	getProfileByEmail(profileEmail: string) : Observable<Profile>{

		return(this.http.get(this.profileUrl+"?profileUserInput="+profileEmail).map(this.extractData).catch(this.handleError));

	}
	putProfile(profile: Profile) : Observable<Profile>{

		return;

	}
}
