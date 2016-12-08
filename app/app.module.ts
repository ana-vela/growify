import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {WeatherService} from "./services/weather-service";
import {PlantService} from "./services/plant-service";
import {CompanionPlantService} from "./services/companion-plant-service";
import {CombativePlantService} from "./services/combative-plant-service";


const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, FormsModule, HttpModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [appRoutingProviders, WeatherService, PlantService, CompanionPlantService, CombativePlantService]
})
export class AppModule {}