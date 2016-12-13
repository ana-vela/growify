import { ViewChild } from '@angular/core';
import {Component} from "@angular/core";
import {LoginComponent} from "./components/login-component"
import {LogoutComponent} from "./components/logout-component"

import {LoginService} from "./services/login-service"



@Component({
	// Update selector with YOUR_APP_NAME-app. This needs to match the custom tag in webpack/index.php
	selector: 'growify-app',

	// templateUrl path to your public_html/templates directory.
	templateUrl: './templates/growify-app.php'
})

export class AppComponent {
	constructor(private loginService: LoginService){}
	@ViewChild(LoginComponent)
		private loginComponent: LoginComponent; // isLoggedIn tracked via login service - ideally we would combine login & logout into the same component for a cleaner design
	@ViewChild(LogoutComponent)
	private logoutComponent: LogoutComponent;

	navCollapse = true;
	loggedIn = false; // note: this value is only to set appropriate nav links
	// it does *NOT* represent adequate authentication!

	toggleCollapse() {
		this.navCollapse = !this.navCollapse;
	}

	/*logoutUser(){
		this.logoutComponent.logoutUser();
	}*/

}