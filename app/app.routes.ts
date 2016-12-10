import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-component";
import {LoginComponent} from "./components/login-component";
import {SignupComponent} from "./components/signup-component";
import {GardenComponent} from "./components/garden-component";
import {PlantsComponent} from "./components/plants-component";
import {SettingsComponent} from "./components/settings-component";
import {SignoutComponent} from "./components/signout-component";
import {WeatherComponent} from "./components/weather-component";
import {TacoComponent} from "./components/taco-component";



export const allAppComponents = [ HomeComponent, LoginComponent, SignupComponent, GardenComponent, PlantsComponent, SettingsComponent, SignoutComponent, TacoComponent, WeatherComponent];

export const routes: Routes = [
	// note: the order the components are listed in matters!
	// the paths should go from most specific to least specific.
	{path: "", component: HomeComponent},
	{path: "login", component: LoginComponent},
	{path: "signup", component: SignupComponent},
	{path: "weather", component: WeatherComponent},
	{path: "garden", component: GardenComponent},
	{path: "plants", component: PlantsComponent},
	{path: "settings", component: SettingsComponent},
	{path: "signout", component: SignoutComponent}


];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);