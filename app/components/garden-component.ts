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
import {Plant} from "../classes/plant"
import {PlantGarden} from "../classes/plantGarden";
@Component({
	templateUrl: "./templates/garden.php",
	providers:[PlantGarden, Plant, Garden]
})

export class GardenComponent implements OnInit{
garden: Garden[]=[];
plantGarden: PlantGarden[]=[];
plant: Plant[] = [];
	constructor(private gardenService: GardenService, private plantService: PlantService){
	}
	ngOnInit():void{
		alert("begin");
		this.gardenService.getGardenByGardenProfileId(34).subscribe(
			(data)=>{
				for(let count = 0; count < data.length; count++){
					this.garden[count] = new Garden(data[count].gardenProfileId,data[count].gardenDatePlanted, data[count].gardenPlantId);
				}
				for(let c=0; c< data.length; c++){
					this.plantService.getPlantByPlantId(this.garden[c].gardenPlantId).subscribe(
						(data)=>{
							this.plant[c] = new Plant(data.plantId, data.plantName, data.plantLatinName, data.plantVariety, data.plantType, data.plantDescription, data.plantSpread, data.plantHeight, data.plantDaysToHarvest, data.plantMinTemp, data.plantMaxTemp, data.plantSoilMoisture, false);
							//plant Garden Initialization
							this.plantGarden[c]= new PlantGarden(this.garden[c],this.plant[c]);
							alert(this.plantGarden[c].plant.plantType);
						}
					)
				}
			}
		);
	}
}