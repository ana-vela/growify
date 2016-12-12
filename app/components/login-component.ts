import {Component, ViewChild, OnInit} from "@angular/core";
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

export class LoginComponent implements OnInit{
	@ViewChild("loginForm") loginForm : any;


	profile: Profile = new Profile(null, "", "", "","");
	status: Status = null;

	constructor(private loginService:LoginService, private profileService:ProfileService, private router: Router){}

	ngOnInit(): void {
	}

	/*isLoggedIn(){
		return this.loginService.isLoggedIn;
	}*/
	loginUser(): void{
		this.loginService.postLogin(this.profile)
			.subscribe(status => {
				this.status = status;
				//this.loginService.isLoggedIn = false;


				if(status.status === 200) {
					this.loginForm.reset();
					setTimeout(function(){$("#login-modal").modal('hide');this.router.navigate(['garden']);},1000);
					//this.profileService.getProfileByUsername(this.profile.profileUsername, this.profile.profilePassword).subscribe(profile=>{this.profile = profile;
					//this.loginService.profile = this.profile;});


					//this.loginService.isLoggedIn = true;


				}
			});

	}

}
