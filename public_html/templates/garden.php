<!-- will need to populate with user's name -->
<h1>Millie's Garden</h1>
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
		<!--<div class="col-md-12">-->
			<table class="table">
				<tr>
					<th>Plant Name</th>
					<th>Date Planted</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				<tr>
					<td>carrots</td>
					<td>04/28/2016</td>
					<td><i class="fa fa-leaf success-leaf fa-2x" aria-hidden="true"></i></td>
					<td>
						<div class="progress">
							<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
								<span class="sr-only">40% Complete (success)</span>
							</div>
						</div>
					</td>
					<td><i class="fa fa-trash" aria-hidden="true"></i></td>
				</tr>
				<tr>
					<td>tomatoes</td>
					<td>03/20/2016</td>
					<td><i class="fa fa-leaf success-leaf fa-2x" aria-hidden="true"></i></td>
					<td>
						<div class="progress">
							<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> 50%
								<span class="sr-only">50% Complete (success)</span>
							</div>
						</div>
					</td>
					<td><i class="fa fa-trash" aria-hidden="true"></i></td>
				</tr>
				<tr>
					<td>sunflowers</td>
					<td>03/28/2016</td>
					<td><i class="fa fa-snowflake-o fa-2x" aria-hidden="true"></i></td>
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
			<div><!--(click)="toggleSelected(plant)" -->
				<button class="btn btn-default" type="button">
					<i class="fa fa-plus" aria-hidden="true"></i>
				</button>
				   Add a Plant
			</div>
		</div>
	<!--</div>-->
</section>
