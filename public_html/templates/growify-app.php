
	<main>
		<!-- Insert Bootstrap navbar, with Angular-friendly links -->
		<nav class="navbar-default">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<!--<span class="icon-bar"></span>-->
					</button>
					<a class="navbar-brand" routerLink="">Growify</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li><a routerLink="">Home</a></li>
						<?php if(empty($_SESSION["profile"]) === true) { ?>
						<li><a href="#" data-toggle="modal" data-target="#login-modal">Login</a></li>
						<li><a href="#" data-toggle="modal" data-target="#signup-modal">Sign Up</a></li>
						<?php } else { ?>
						<li><a routerLink="/garden">Garden</a></li>
						<li><a routerLink="/plants">Plants</a></li>
						<li><a href="#" data-toggle="modal" data-target="#logout-modal" onclick="logoutUser()">Logout</a></li>
						<?php } ?>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
		<router-outlet></router-outlet>


	</main>








