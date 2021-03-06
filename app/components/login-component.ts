import {Component, ViewChild, OnInit, EventEmitter, Output} from "@angular/core";
import {LoginService} from "../services/login-service";
import {ProfileService} from "../services/profile-service";
import {Router} from "@angular/router";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";
declare var $: any;


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
					this.router.navigate(['garden']);
					this.loginForm.reset();

					this.loginService.isLoggedIn = true;
					this.isLoggedIn = true;// *ONLY* use for setting appropriate nav links, this
					// does not provide secure information (not adequate authentication)
				}
			});

	}

	logoutUser(): void{
		this.loginService.getLogout()
			.subscribe(status => {
				this.status = status;
				/* TODO success -- display message, redirect to home page
				 * failure - display error message on form*/
				if (status.status === 200) {
					this.router.navigate(['']);
					this.loginService.isLoggedIn = false;
					this.isLoggedIn = false;

					setTimeout(function(){$("#logout-modal").modal('hide');},1000);



			}
			});

	}


}
