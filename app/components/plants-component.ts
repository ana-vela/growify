
import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {PlantService} from "../services/plant-service";
import {Observable} from "rxjs/Observable"
import {Plant} from "../classes/plant";

import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/plants.php"
})

export class PlantsComponent implements OnInit{

	dataReady = false;
	testPlant: string = ""; // value for test
	plantName: string = ""; // search term from plant-form
	plantLatinName: string = ""; // search term from form
	plantId: number = 0; // for searching by plantId
	allPlants: Plant[] = []; // get all plants
	plantResults: Plant[] = []; // search results

	testPlants = [new Plant(1, "star flower", "Expecto patronus","flower", "flower", "badass",7,  7, 7, 15, 140, "D"),
		new Plant(1, "beetroot", "Beetle bug","flower", "flower", "badass",7,  7, 7, 15, 140, "D")];

	constructor(private plantService: PlantService){}

	ngOnInit(): void {
		this.getAllPlants();
	}

	testSubmit(): void{
		this.testPlant = "tasty plant";
	}

	searchForPlantsByName(): void{


		this.plantService.getPlantsByName(this.plantName).subscribe(plants=>this.plantResults.concat(plants));
	}

	searchForPlantsByLatinName(): void{
		this.plantService.getPlantsByLatinName(this.plantLatinName).subscribe(plants=>this.plantResults.concat(plants));
	}
/*
	getAllPlants(): void{
		this.plantService.getAllPlants()
			.subscribe(function(plants){this.allPlants = plants; this.dataReady=true;});
	}
*/
	getAllPlants(): void{
		this.plantService.getAllPlants()
			.subscribe(plants=>{this.allPlants = plants;
												this.dataReady = true;});
	}

	filterPlantsOnPlantName(): void{
		if(this.plantName !== null){
			this.plantResults=this.allPlants.filter((plant: Plant)=>plant.plantName.toLowerCase().indexOf(this.plantName.toLowerCase()) >= 0);
		}
	}
	/*searchForPlantByPlantId(): void{
	 this.plantService.getPlantByPlantId(this.plantId).subscribe(plant=>this.plantResults.concat(plant));
	 }*/
	/*
	 searchForPlantsByPlantId(): void{
	 this.plantService.getPlantByPlantId(this.plantId).subscribe(plants=>this.plantResults.concat(plants));
	 }
	 */

}