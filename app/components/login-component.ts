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
				/* TODO success -- display message, redirect to garden page
				* failure - display error message on form*/
				if(status.status === 200) {
					this.loginForm.reset()
				}
			});

	}
}
