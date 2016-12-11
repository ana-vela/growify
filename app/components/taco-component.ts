import {Component} from "@angular/core";

@Component({
	selector: "taco",
	templateUrl: "./templates/taco.php"
})

export class TacoComponent {
	shouldHaveTacos(): boolean {
		return (true);
	}
}
