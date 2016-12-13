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
		<tr *ngFor="let item of plantGarden">
			<td>{{item.plant.plantName}}</td>
			<td>{{item.datePlantedMillis | date:'mediumDate'}}</td>

			<td ngSwitch="{{item.plant.plantType}}"> <!-- do not add a space between <i> tags!! -->
				<i *ngSwitchCase="'Vegetable'" class="fa fa-crop fa-2x"></i><i *ngSwitchDefault class="fa fa-leaf fa-2x" id="{{item.plant.plantType}}"></i>
			</td>

			<td>
				<!--<div class="progress" [hidden]="(item.progress === null) || (item.progress <= 0)">
					<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"  aria-valuemin="0" aria-valuemax="100" [style]={{item.progressStyle}}>
						<span class="sr-only">{{item.progress}}% Complete (success)</span>

					</div>
				</div>-->
				<div class=" harvest-progress" >
					<i class="fa fa-circle" *ngFor="let i of item.progressDots "></i>
					<i class="fa fa-circle gray-dot" *ngFor="let i of item.incompleteDots "></i>
				</div>
			</td>
			<td>{{item.progress | number:'1.0-0'}}&#37;</td>
			<td><i class="fa fa-trash fa-2x" aria-hidden="true"></i></td>
		</tr>
	</table>
</div>

</section>
