import{Component} from "@angular/core";
import {Status} from "../classes/status";
import {LoginService} from "../services/login-service";

@Component({
	templateUrl: "./templates/signout.php",
	selector: "logout-component"
})

export class LogoutComponent {


	constructor(private loginService: LoginService){}
	status: Status = null;

	logoutUser(): void{
		this.loginService.getLogout()
			.subscribe(status => {
				this.status = status;
				/* TODO success -- display message, redirect to home page
				 * failure - display error message on form*/
				this.loginService.isLoggedIn = false;

			});

	}
}