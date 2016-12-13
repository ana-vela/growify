import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "../services/base-service";
import {Garden} from "../classes/garden";
import {Status} from "../classes/status";
import {GardenService} from "../services/garden-service";
import{PlantService} from "../services/plant-service";
import{PlantAreaService} from "../services/plant-area-service";
import{ProfileService} from "../services/profile-service";
import {Plant} from "../classes/plant"
import {PlantGarden} from "../classes/plantGarden";
import {Profile} from "../classes/profile";
declare var $: any;

@Component({
	templateUrl: "./templates/garden.php"
})

export class GardenComponent implements OnInit {
	garden: Garden[] = [];
	plantGarden: PlantGarden[] = [];
	plant: Plant[] = [];
	profile: Profile = new Profile(0, "", "", "", "");

	constructor(private gardenService: GardenService, private plantService: PlantService, private profileService: ProfileService) {
	}

	ngOnInit(): void {
		$("#login-modal").modal('hide');
		$('body').removeClass('modal-open');
		$('.modal-backdrop').remove();
		this.gardenService.getGardens().subscribe(
			garden => {
				this.garden = garden;

				for(let c = 0; c < this.garden.length; c++) {
					this.plantService.getPlantByPlantId(this.garden[c].gardenPlantId).subscribe(
						plant => { // for all of the plants in the garden, retrieve the plant area and store it.
							this.plant.push(plant);

							let progress = 0;
							if(plant.plantDaysToHarvest !== null && plant.plantDaysToHarvest !== 0 && this.garden[c].gardenDatePlanted !== null){
									let currentTime = Date.now();
									let elapsedDays = (currentTime-Number.parseInt(this.garden[c].gardenDatePlanted))/(1000*60*60*24);
									if(elapsedDays >= plant.plantDaysToHarvest){
										progress = 100;
									} else if(elapsedDays > 0){
											progress = (elapsedDays / plant.plantDaysToHarvest)*100;
									}

							}
							let newPlantGarden: PlantGarden = new PlantGarden(this.garden[c], plant, Number.parseInt(this.garden[c].gardenDatePlanted), progress);
							this.plantGarden.push(newPlantGarden);
						})

				}
			}
		);

		this.profileService.getProfile().subscribe(profile=>this.profile=profile);

	}
}