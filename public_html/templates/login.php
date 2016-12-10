<!--<section class="login">
	<div class="container">
		<div class="jumbotron text-center">
			<h1>Login Page</h1>
			<p class="lead">Login to see your garden list! </p>
		</div>
	</div>
</section>

<a href="#" data-toggle="modal" data-target="#login-modal">Login</a>-->

<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" >
	<div class="modal-dialog">
		<div class="loginmodal-container">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h1>Login to Growify!</h1><br>

			<form #loginForm="ngForm" name="loginForm" id="loginForm" class="form-vertical well"
					(ngSubmit)="loginUser();" >
			<input type="text" name="user" placeholder="Username" class="form-control" required [(ngModel)]="profile.profileUsername" #profileUsername="ngModel">
			<input type="password" name="pass" class="form-control" placeholder="Password" required [(ngModel)]="profile.profilePassword" #profilePassword="ngModel">
			<input type="submit" name="login" class="login loginmodal-submit" value="Login">
				<div *ngIf="status !== null" class="alert alert-dismissible"
					  [ngClass]="status.type" role="alert">

					{{ status.message }}
				</div>

			</form>
		</div>
	</div>
</div>
