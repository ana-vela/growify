<section class="welcome">
	<div class="home">
			<div class="container-fluid text-center">

			<h1>Welcome to Growify!</h1>
			<p class="lead">This is an app for supplying growing information for home gardeners!</p>
			<!--<a routerLink="/weather">Weather</a>-->
		</div>
		<div class="row center-block">
			<div class="col-md-1">
			<button type="button" class="btn btn-primary center-block" data-toggle="modal" data-target="#login-modal">Login</button>
			</div>
		<div class="col-md-1">
			<button type="button" class="btn btn-primary center-block" data-toggle="modal" data-target="#signup-modal">Sign Up</button>
		</div>
		</div>

	</div>
	<login-component></login-component>
	<signup-component></signup-component>
	<signout-component></signout-component>
</section>

