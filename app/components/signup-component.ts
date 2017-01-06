import {Component, ViewChild, OnInit} from "@angular/core";
import {ProfileService} from "../services/profile-service";
import {Router} from "@angular/router";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";
declare var $: any;

@Component({
	templateUrl: "./templates/signup.php",
	selector: "signup-component"
})

export class SignupComponent implements OnInit{
	@ViewChild("signUpForm") signUpForm : any;
	profile: Profile = new Profile(null,"", "", "","");
	//testProfile: Profile = new Profile(null, "gbloom3", "87112", "gbloomdev@gmail.com", "abc123");
	status: Status = null;

	constructor(private profileService: ProfileService, private router: Router){}

	ngOnInit(): void {
	}

	createProfile() : void {

		this.profileService.postProfile(this.profile)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.signUpForm.reset()
					alert("Please check your inbox for an email to activate your account. Thank you.");
					setTimeout(function(){$("#signup-modal").modal('hide');},1000);
				}
			});
	}
}