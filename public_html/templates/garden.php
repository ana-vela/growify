<div class="container">
<!-- will need to populate with user's name-->
	<h1>{{profile.profileUsername}}'s Garden</h1>
</div>
<section class="weather-display">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<weather-component></weather-component>
			</div>
		</div>
	</div>
</section>
<section>


<div class="container">

	<div class="add-plant">
		<button routerLink="/plants" class="btn btn-success" type="button">
			Click here to add plants
		</button>
	</div>

	<table class="table table-condensed">
		<tr>
			<th>Plant Name</th>
			<th>Date Planted</th>
			<th class="icon"></th>
			<th class="harvest-progress"></th>
			<th class="percentage-progress"></th>
			<th></th>
		</tr>
		<tr *ngFor="let item of plantGarden; let index = index">
			<td>{{item.plant.plantName}}</td>
			<!--<td><a data-target="#date-modal" href="#" (click)="selectDate(item.datePlantedMillis)">{{item.datePlantedMillis | date:'mediumDate'}}</a></td>-->
			<td>{{item.datePlantedMillis | date:'mediumDate'}}</td>

			<td ngSwitch={{icons[index]}}>
				<i *ngSwitchCase="'true'" class="fa fa-leaf fa-2x"> </i>
				<i *ngSwitchCase="'false'" class="fa fa-snowflake-o fa-2x">  </i>
				<i *ngSwitchDefault> {{icons[index]}}</i>
			</td>

			<td>
				<!--<div class="progress" [hidden]="(item.progress === null) || (item.progress <= 0)">
					<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"  aria-valuemin="0" aria-valuemax="100" [style]={{item.progressStyle}}>
						<span class="sr-only">{{item.progress}}% Complete (success)</span>

					</div>
				</div>-->
				<div class="progress harvest-progress" [hidden]="(item.progress === null) || (item.progress <= 0)">
					<!--<i class="fa fa-circle" *ngFor="let i of item.progressDots "></i>
					<i class="fa fa-circle gray-dot" *ngFor="let i of item.incompleteDots "></i>-->
					<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" [ngStyle]="{'width': item.progress+'%'}">
						<span class="sr-only">{{item.progress}}% Complete (success)</span>
					</div>
				</div>
			</td>
			<td>{{item.progress | number:'1.0-0'}}&#37;</td>
			<td><button type="delete" class="fa fa-trash fa-2x" aria-hidden="true" (click)="onDelete(item, item.garden.gardenPlantId);"></button></td>
		</tr>
	</table>
</div>

<!--
	<div class="modal fade" id="date-modal" tabindex="-1" role="dialog" >
		<div class="date-dialog">
			<div class="datemodal-container">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h1>Date Planted</h1>

				<form>
					<input type="month">
					<input type="date">
					<button type="submit" class="btn btn-success">OK</button>
				</form>
			</div>
		</div>
	</div>
-->

</section>

