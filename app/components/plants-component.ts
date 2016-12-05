import{Component} from "@angular/core";
import {Router} from "@angular/router";
import {PlantService} from "../services/plant-service";
import {Observable} from "rxjs/Observable"
import {Plant} from "../classes/plant";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/plants.php"
})

export class PlantsComponent {

	plantSearch: Plant[] = [];

	constructor(private plantService: PlantService){}

	searchForPlantsByName(plantName: string): void{

		this.plantService.getPlantsByName(plantName).subscribe(plants=>this.plantSearch.concat(plants));
	}

	searchForPlantsByLatinName(plantLatinName: string): void{
		this.plantService.getPlantsByLatinName(plantLatinName).subscribe(plants=>this.plantSearch.concat(plants));
	}

	searchForPlantsByPlantId(plantId: number): void{
		this.plantService.getPlantsByPlantId(plantId).subscribe(plant=>this.plantSearch.concat(plant));
	}

}