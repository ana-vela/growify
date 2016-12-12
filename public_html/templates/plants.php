<section class="plants">

	<div class="container">

		<h1>Plants List</h1>
		<p class="lead">Search for herbs and vegetables here!</p>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<!--<form #plantForm="ngForm" novalidate name="plantForm" id="plantForm" class="form-inline"  >-->

					<div class="input-group">
						<label for="plant-search" class="sr-only">Search</label>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search for Plant by Name&hellip;" name="plantName" id="plantName" title="plantName" [(ngModel)]="plantName" (keyup)="filterPlantsOnPlantName();">

							<span class="input-group-addon"><i class="fa fa-search fa-flip-horizontal" aria-hidden="true" ></i></span>

								<div class="col-md-6">
									<button class="btn btn-success" type="submit" (click)="addSelectedPlantsToGarden()">Add Selected Plants</button>

<!--									<button class="btn btn-default" type="button" (click)="addSelectedPlantsToGarden()">Add Selected Plants</button>-->

<!--									<button class="btn btn-success" type="submit"><i class="fa fa-paper-plane"></i> Send</button>-->
								</div>
<!--								<div class="col-md-6" [hidden]="addPlantsSuccess===true">Success! Plants added to garden.</div>-->
						</div>
						</div>
					</div>
				<!--</form>-->
				<!-- Search Results Table -->
			</div>

		<div [hidden]="dataReady">Preparing Data&hellip;</div>
		<div class="row">
			<div class="col-md-10">
				<table class="table" id="plant-table">

					<tr *ngFor="let plant of plantResults" [ngClass]="{'selected-plant': plant.isSelected}">
						<td>
							<button class="btn btn-default" type="button" (click)="toggleSelected(plant)" >
								<i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</td>
						<td><a href="#" (click)="setModalPlant(plant)" data-toggle="modal" data-target="#plantDetailModal">{{plant.plantName}}</a></td>
						<td><em>{{plant.plantLatinName}}</em></td>
						<td>{{plant.plantVariety}}</td>
					</tr>
				</table>
			</div>
		</div>

<!--		<div class="row">
			<div class="col-md-4">
				<button class="btn btn-default" type="button" (click)="addSelectedPlantsToGarden()">Add Selected Plants</button>
			</div>
			<div class="col-md-4" [hidden]="addPlantsSuccess===true">Success! Plants added to garden.</div>
		</div>--

		<!-- Modal for detailed plant data display -->
		<!-- get the plantId that was clicked from the modalPlant field -->
		<div class="modal fade" id="plantDetailModal" tabindex="-1" role="dialog" aria-labelledby="plantDetailModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" (click)="clearModalPlant()"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel"> {{modalPlant.plantName}} <span *ngIf="modalPlant.plantVariety!==null"> - {{modalPlant.plantVariety}}</span></h4>
					</div>
					<div class="modal-body">
						<p><em>{{modalPlant.plantLatinName}}</em><p>
						<p><b>Spread:</b> {{modalPlant.plantSpread | number:'1.0-1'}} ft.</p>
						<p><b>Height:</b> {{modalPlant.plantHeight | number:'1.0-1'}} ft.</p>
						<p><b>Days to Harvest:</b> {{modalPlant.plantDaysToHarvest | number:'.0-0'}}</p>
						<p *ngIf="modalPlantArea">Recommended Planting Dates: {{modalPlantArea.plantAreaStartDay}}/{{modalPlantArea.plantAreaStartMonth}} - {{modalPlantArea.plantAreaEndDay}}/{{modalPlantArea.plantAreaEndMonth}}</p>
						<h4>Description:</h4>
						<p>{{modalPlant.plantDescription}}</p>
						<!-- Companion Plant & Combative Plant data -->
						<div class="row">
							<div class="col-md-6">
								<div class="well " id="companion-plants">

									<b>Companion Plants</b>
									<ul>
										<li *ngFor="let companionPlant of companionPlantNames">{{companionPlant}}</li>

									</ul>

								</div>
							</div>
							<div class=" col-md-6">
								<div class="well " id="combative-plants">

									<b>Combative Plants</b>
									<ul>
										<li *ngFor="let combativePlant of combativePlantNames">{{combativePlant}}</li>

									</ul>

								</div>
							</div>
						</div>



					</div>

				</div>
			</div>
		</div>

	</div>

</section>
