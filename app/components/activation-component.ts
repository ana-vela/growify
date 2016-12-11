import {Component,OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {ActivationService} from "../services/activation-service";

@Component({
	templateUrl: "./templates/signup.php",
	selector: "activation-component"
})

export class ActivationComponent implements OnInit{
	status: Status = null;

	constructor(private activationService: ActivationService, private router: Router){}

	ngOnInit(): void {
	}

	createProfile() : void {

		this.activationService.getActivation()
			.subscribe(status => {
				this.status = status;
			});
	}
}