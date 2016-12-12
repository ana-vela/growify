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
	<table class="table">
		<tr>
			<th>Plant Name</th>
			<th>Date Planted</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<tr *ngFor="let item of plantGarden">
			<td>{{item.plant.plantName}}</td>
			<td>{{item.datePlantedMillis | date:'mediumDate'}}</td>

			<td ngSwitch="{{item.plant.plantType}}">
				<i *ngSwitchCase="'Vegetable'" class="fa fa-crop fa-2x"></i> <!--Add correct crop-->
				<i *ngSwitchDefault class="fa fa-leaf fa-2x" id="{{item.plant.plantType}}"></i>
			</td>

			<td>
				<div class="progress" [hidden]="(item.progress === null) || (item.progress <= 0)">
					<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="item.progress" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
						<span class="sr-only">{{item.progress}}% Complete (success)</span>
					</div>
				</div>
			</td>
			<td><i class="fa fa-trash" aria-hidden="true"></i></td>
		</tr>
	</table>
</div>
			<div>
				<button routerLink="/plants" class="btn btn-default" type="button">
					Click here to add plants

				</button>
			</div>
</section>
