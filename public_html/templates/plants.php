<section class="plants">



	<div class="container">

		<h1>Plants List</h1>
		<p class="lead">Search for herbs and vegetables here!</p>

		<div class="row">
			<div class="col-md-10">
				<form id="plantForm" class="form-inline"  ><!-- add (ngSubmit)="plantSearch()" -->

					<div class="form-group">
						<label for="plant-search" class="sr-only">Search</label>
						<div class="input-group">
							<input type="text" name="plant-search" id="plant-search" title="plant-search" >

							<span class="input-group-button">
							<a class="btn btn-default" type="submit"><i class="fa fa-search fa-flip-horizontal" aria-hidden="true"></i>
</a>
							</span>

						</div>
					</div>

				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10">
				<table class="table  " id="plant-table">
					<!-- do we want class table responsive? -->
					<tr>
						<td>
							<a class="btn btn-default" type="button">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</a>
						</td>
						<td>Plant1 Name</td>
						<td><em>latin name</em></td>
						<td>12/12/2012</td>
						<td>Freeze Warning!</td>
					</tr>
					<tr>
						<td>
							<button class="btn btn-default" type="button">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</td>
						<td>Plant2 Name</td>
						<td><em>latin name</em></td>
						<td>01/02/2017</td>
						<td>Freeze Warning!</td>
					</tr>
				</table>
			</div>
		</div>

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

</section>
