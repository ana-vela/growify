import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "../services/base-service";
import {Garden} from "../classes/garden";
import {Status} from "../classes/status";
import {GardenService} from "../services/garden-service";

@Component({
	templateUrl: "./templates/garden.php"
})

export class GardenComponent implements OnInit{
garden: Garden[]=[];

	constructor( private gardenService: GardenService){
	}
	ngOnInit():void{
		this.gardenService.getGardenByGardenProfileId(19).subscribe(garden=>this.garden=garden);
	}

}