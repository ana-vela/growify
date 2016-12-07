<section class="plants">



	<div class="container">

		<h1>Plants List</h1>
		<p class="lead">Search for herbs and vegetables here!</p>

		<div class="row">
			<div class="col-md-10">
				<!--<form #plantForm="ngForm" novalidate name="plantForm" id="plantForm" class="form-inline"  >-->

					<div class="input-group" >
						<label for="plant-search" class="sr-only">Search</label>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search for Plant by Name&hellip;" name="plantName" id="plantName" title="plantName" [(ngModel)]="plantName" (keyup)="filterPlantsOnPlantName();">

							<span class="input-group-addon"><i class="fa fa-search fa-flip-horizontal" aria-hidden="true" ></i></span>

						</div>
					</div>

				<!--</form>-->

				<!-- Search Results Table -->
			</div>
		</div>
		<div [hidden]="dataReady">Preparing Data&hellip;</div>
		<div class="row">
			<div class="col-md-10">
				<table class="table  " id="plant-table">

					<tr *ngFor="let plant of plantResults" >
						<td>
							<button class="btn btn-default" type="button" >
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

		<div class="row">
			<div class="col-md-4">
				<button class="btn btn-default" type="button" (click)="">Add Selected Plants</button><!-- TODO add click event binding - add selected plants to garden and redirect to garden-->
			</div>
		</div>


		<!-- Modal for detailed plant data display -->
		<!-- get the plantId that was clicked from the modalPlant field -->
		<div class="modal fade" id="plantDetailModal" tabindex="-1" role="dialog" aria-labelledby="plantDetailModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel"> {{modalPlant.plantName}} <span *ngIf="modalPlant.plantVariety!==null"> - {{modalPlant.plantVariety}}</span></h4>
					</div>
					<div class="modal-body">
						<p><em>{{modalPlant.plantLatinName}}</em><p>
						<p><b>Spread:</b> {{modalPlant.plantSpread | number:'.0-1'}}</p>
						<p><b>Height:</b> {{modalPlant.plantHeight | number:'.0-1'}}</p>
						<p><b>Days to Harvest:</b> {{modalPlant.plantDaysToHarvest | number:'.0-0'}}</p>
						<h4>Description:</h4>
						<p>{{modalPlant.plantDescription}}</p>
						<!-- Companion Plant & Combative Plant data -->
						<div class="row">
							<div class="col-xs-6 col-md-4">
								<div class="well " id="companion-plants">

									<h3>Companion Plants</h3>
									<ul>
										<li>orange</li>
										<li>strawberry</li>
										<li>peach</li>
									</ul>

								</div>
							</div>
							<div class="col-xs-6 col-md-4">
								<div class="well " id="combative-plants">

									<h3>Combative Plants</h3>
									<ul>
										<li>prickly pear</li>
										<li>saguaro</li>
										<li>cholla</li>
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
