<section class="welcome">
	<div class="home">
		<div class="container-fluid text-center">

			<div>
				<h1>Welcome to Growify!</h1>
				<p class="lead">A Farmers' Almanac for Home Gardeners!</p>
				<!--<a routerLink="/weather">Weather</a>-->
			</div>
			<div class="row center-block">
				<div class="col-md-2 col-md-offset-9">
					<div class="row">
						<button type="button" class="btn btn-primary center-block" data-toggle="modal" data-target="#login-modal">Login</button>
					</div>
					<div class="row">
						<button type="button" class="btn btn-primary center-block" data-toggle="modal" data-target="#signup-modal">Sign Up</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if(empty($_SESSION["profile"]) === true) { ?>
	<login-component></login-component>
	<signup-component></signup-component>
	<?php } else { ?>
	<logout-component></logout-component>
	<?php } ?>
</section>

