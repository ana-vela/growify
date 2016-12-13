import {Component, ViewChild, OnInit, EventEmitter, Output} from "@angular/core";
import {LoginService} from "../services/login-service";
import {ProfileService} from "../services/profile-service";
import {Router} from "@angular/router";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";


@Component({
	templateUrl: "./templates/login.php",
	selector: "login-component"
})

export class LoginComponent implements OnInit {
	@ViewChild("loginForm") loginForm: any;


	profile: Profile = new Profile(null, "", "", "", "");
	status: Status = null;

	constructor(private loginService: LoginService, private profileService: ProfileService, private router: Router) {
	}

	ngOnInit(): void {
	}

	isLoggedIn = false;

	ngOnChanges (): void {


	this.isLoggedIn = this.loginService.isLoggedIn;

}

	loginUser(): void{
		this.loginService.postLogin(this.profile)
			.subscribe(status => {
				this.status = status;
				this.loginService.isLoggedIn = false;// *ONLY* use for setting appropriate nav links, this
				// does not provide secure information (not adequate authentication)


				if(status.status === 200) {
					this.loginForm.reset();
					this.router.navigate(['garden']);
					//this.profileService.getProfileByUsername(this.profile.profileUsername, this.profile.profilePassword).subscribe(profile=>{this.profile = profile;
					//this.loginService.profile = this.profile;});


					this.loginService.isLoggedIn = true;
					this.isLoggedIn = true;// *ONLY* use for setting appropriate nav links, this
					// does not provide secure information (not adequate authentication)




				}
			});

	}

}
