import {Component, ViewChild, OnInit} from "@angular/core";
import {LoginService} from "../services/login-service";
import {Router} from "@angular/router";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/login.php",
	selector: "login-component"
})

export class LoginComponent implements OnInit{
	@ViewChild("loginForm") loginForm : any;
	profileUsername: string = ""; // username from form
	profileEmail: string = ""; // email from form
	profileZipCode: string = ""; // zipcode from form
	profilePassword: string = ""; // password from form
	profile: Profile = new Profile(null, "", "", "","");
	testProfile: Profile = new Profile(null, "gbloom3", "87112", "gbloomdev@gmail.com", "abc123");
	status: Status = null;

	constructor(private loginService:LoginService, private router: Router){}

	ngOnInit(): void {
	}

	loginUser(): void{
		this.loginService.postLogin(this.profile)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.loginForm.reset()
				}
			});

	}
}
