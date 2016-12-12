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

import {Plant} from "../classes/plant"
import {PlantGarden} from "../classes/plantGarden";

@Component({
	templateUrl: "./templates/garden.php"
})

export class GardenComponent implements OnInit {
	garden: Garden[] = [];
	plantGarden: PlantGarden[] = [];
	plant: Plant[] = [];

	constructor(private gardenService: GardenService, private plantService: PlantService) {
	}

	ngOnInit(): void {
		this.gardenService.getGardens().subscribe(
			garden => {
				this.garden = garden;

				for(let c = 0; c < this.garden.length; c++) {
					this.plantService.getPlantByPlantId(this.garden[c].gardenPlantId).subscribe(
						plant => { // for all of the plants in the garden, retrieve the plant area and store it.
							this.plant.push(plant);
							let newPlantGarden: PlantGarden = new PlantGarden(this.garden[c], plant);
							this.plantGarden.push(newPlantGarden);

						})

				}
			}
		);
	}
}