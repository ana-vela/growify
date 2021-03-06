
import{Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {PlantService} from "../services/plant-service";
import {CompanionPlantService} from "../services/companion-plant-service";
import {CombativePlantService} from "../services/combative-plant-service";
import {ProfileService} from "../services/profile-service";
import {GardenService} from "../services/garden-service";
import {PlantAreaService} from "../services/plant-area-service";


import {Observable} from "rxjs/Observable"
import {Plant} from "../classes/plant";
import {PlantArea} from "../classes/plantArea";

import {Garden} from "../classes/garden";

import {CompanionPlant} from "../classes/companionPlant";
import {CombativePlant} from "../classes/combativePlant";
import {Profile} from "../classes/profile";



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
	modalPlant: Plant = new Plant(0, "", "", "", "", "", 0, 0, 0, 0, 0, "");
	modalPlantArea: PlantArea = null;

	selectedPlants: Plant[]=[]; // user clicks to select a bunch of plants.
	status: Status = null; // status of adding a plant.
	addPlantsSuccess = false; // display a message if plants added successfully
	/* companion plants and combative plants set by the modal plant */
	companionPlants: CompanionPlant[]=[]; // store list of companion plants corresponding to selected plants search term
	companionPlantNames: string[] = []; // store list of companion plants for display

	combativePlants: CombativePlant[]=[]; // store list of combative plants corresponding to selected plants search term
	combativePlantNames: string[] = []; // store list of combative plants for display

	testPlants = [new Plant(1, "star flower", "Expecto patronus","flower", "flower", "badass",7,  7, 7, 15, 140, "D"),
		new Plant(1, "beetroot", "Beetle bug","flower", "flower", "badass",7,  7, 7, 15, 140, "D")];

	profile: Profile = new Profile(0, "", "", "", "");

	constructor(private plantService: PlantService, private companionPlantService: CompanionPlantService, private combativePlantService: CombativePlantService, private profileService: ProfileService, private gardenService: GardenService, private plantAreaService: PlantAreaService){}

	ngOnInit(): void {
		this.getAllPlants();
		this.profileService.getProfile().subscribe(profile=> {
			this.profile = profile;
			//this.plantAreaService.get...
		});
	}

	testSubmit(): void{
		this.testPlant = "tasty plant";
	}

//todo when user clicks add all to garden to add then, remember to remove the "selected" quality
	addSelectedPlantsToGarden(){
		// toggle selected for all items in selected array (this will set them to selected = false)
		// get profile id and add items to garden
		for(let i = 0; i < this.selectedPlants.length; i++){
			let plant = this.selectedPlants[i];
			plant.isSelected = false;
			let garden = new Garden(this.profile.profileId, "", plant.plantId);
			this.gardenService.postGarden(garden).subscribe(status => {
				this.addPlantsSuccess = true;
				this.status = status;
				if(status.status !== 200) {
					this.addPlantsSuccess = false;
				}
			});
		}
		this.selectedPlants=[]; // hopefully plants will now be garbage-collected :)
	}



	toggleSelected(plant: Plant) {
		// check if plant is in "selected" plants list
		// remove the plant from the list
		this.addPlantsSuccess = false;

		if(plant.isSelected) {
			plant.isSelected = false;
			let index = this.selectedPlants.indexOf(plant);
			// remove the selected plant from the list
			this.selectedPlants.splice(index, 1);
		} else {
		// add the plant to the list

		this.selectedPlants.push(plant);
		plant.isSelected = true;


		}


	}

	searchForPlantsByName(): void{


		this.plantService.getPlantsByName(this.plantName).subscribe(plants=>this.plantResults = plants);
	}

	searchForPlantsByLatinName(): void{
		this.plantService.getPlantsByLatinName(this.plantLatinName).subscribe(plants=>this.plantResults = plants);
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

	clearModalPlant(){
		this.modalPlant = new Plant(0, "", "", "", "", "", 0, 0, 0, 0, 0, "");
		this.modalPlantArea = null;
		this.companionPlantNames = [];
		this.combativePlantNames = [];
	}

	setModalPlant(selectedPlant :Plant): void{
		// set plant
		// get detail info via get plant by plant id
		this.plantService.getPlantByPlantId(selectedPlant.plantId).subscribe(plant=>this.modalPlant = plant);
		//this.companionPlants = []; // ensure list of combative plants is cleared
		this.companionPlantService.getCompanionPlantsByName(selectedPlant.plantName).subscribe(companionPlants=>this.addCompanionPlantsToList(companionPlants, selectedPlant.plantName));


		//this.combativePlants = []; // ensure list of combative plants is cleared
		this.combativePlantService.getCombativePlantsByName(selectedPlant.plantName).subscribe(combativePlants=>this.addCombativePlantsToList(combativePlants, selectedPlant.plantName));

		this.plantAreaService.getPlantAreaByPlantId(selectedPlant.plantId).subscribe(plantArea=>this.modalPlantArea=plantArea);

	}

	addCombativePlantsToList(combativePlants: CombativePlant[], plantName: string){
		this.combativePlants=combativePlants;
		for(let i =0; i <this.combativePlants.length; i++){
			let combativePlant: CombativePlant = this.combativePlants[i];
			let plant1 = combativePlant.combativePlant1Name;
			let plant2 = combativePlant.combativePlant2Name;
			// when we get a pair, we want to create a list of the *other* combative plant of the pair.
			if(plant1.toLowerCase().indexOf(plantName.toLowerCase())>=0) {
				this.combativePlantNames.push(plant2);
			} else if(plant2.toLowerCase().indexOf(plantName.toLowerCase())>=0){
				this.combativePlantNames.push(plant1)
			}
		}
	}

	addCompanionPlantsToList(companionPlants: CompanionPlant[], plantName: string){
		this.companionPlants=companionPlants;
		for(let i = 0; i < this.companionPlants.length; i++){
			let companionPlant: CompanionPlant = this.companionPlants[i];
			let plant1 = companionPlant.companionPlant1Name;
			let plant2 = companionPlant.companionPlant2Name;
			if(plant1.toLowerCase().indexOf(plantName.toLowerCase())>=0) {
				this.companionPlantNames.push(plant2);
			} else if(plant2.toLowerCase().indexOf(plantName.toLowerCase())>=0){
				this.companionPlantNames.push(plant1)
			}
		}

	}


}