<div class="container">
<!-- will need to populate with user's name-->
	<h1>Millie's Garden</h1>
</div>
<section class="weather-display">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<weather-component></weather-component>
			</div>
		</div>
</section>
<div class="container">
	<table class="table">
		<tr>
			<th>Plant Name</th>
			<th>Date Planted</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<tr *ngFor="let item of plantGarden">
			<td>Plant Name of:{{item.plant.plantName}}</td>
			<td>Date Planted of: {{item.garden.gardenDatePlanted}}</td>
		</tr>
</table>
			<td [ngSwitch]="let item.plant.plantType of plantGarden">
				<i [ngSwitchCase]="Vegetable" class="fa fa-car success-leaf fa-2x" aria-hidden="true"></i>
				<i [ngSwitchCase]="Fruit" class="fa fa-car success-leaf fa-2x" aria-hidden="true"></i>
				<i [ngSwitchDefault] class="fa fa-leaf success-leaf fa-2x" aria-hidden="true"></i>
			</td>
			<td>
				<div class="progress">
					<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
						<span class="sr-only">40% Complete (success)</span>
					</div>
				</div>
			</td>
			<td><i class="fa fa-trash" aria-hidden="true"></i></td>
		</tr>
	</table>
</div>
			<div>(click)="toggleSelected(plant)"
				<button class="btn btn-default" type="button">
					<i class="fa fa-plus" aria-hidden="true"></i>
				</button>
				   Add a Plant
			</div>
</section>
