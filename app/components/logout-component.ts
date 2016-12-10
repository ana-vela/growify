import{Component} from "@angular/core";
import {Status} from "../classes/status";
import {LogoutService} from "../services/logout-service";

@Component({
	templateUrl: "./templates/signout.php",
	selector: "logout-component"
})

export class LogoutComponent {

	constructor(private logoutService: LogoutService){}
	status: Status = null;

	logoutUser(): void{
		this.logoutService.getLogout()
			.subscribe(status => {
				this.status = status;
				/* TODO success -- display message, redirect to home page
				 * failure - display error message on form*/
			});

	}
}