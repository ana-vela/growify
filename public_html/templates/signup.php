<div class="modal fade" id="signup-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="signupmodal-container">
			<div class="container">
				<div class="row centered-form">
					<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h3 class="panel-title text-center">Please sign up for Growify!</h3>
							</div>
							<div class="panel-body">
								<form #signUpForm="ngForm" name="signUpForm" id="signUpForm" class="form-vertical well"
										(ngSubmit)="createProfile();">
									<label for="profileUsername">Username</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-comment" aria-hidden="true"></i>
										</div>
										<input type="text" name="profile" id="profile" class="form-control" maxlength="255"
												 required [(ngModel)]="profile.profileUsername" #profileUsername="ngModel"/>
									</div>
									<div [hidden]="profileUsername.valid || profileUsername.pristine" class="alert alert-danger"
										  role="alert">
										<p *ngIf="profileUsername.errors?.required">Username is required.</p>
										<p *ngIf="profileUsername.errors?.maxlength">Username is too long. You typed</p>
									</div>
									<div class="form-group"
										  [ngClass]="{ 'has-error': profileEmail.touched && profileEmail.invalid }">
										<label for="profileEmail">Email</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-quote-left" aria-hidden="true"></i>
											</div>
											<input type="text" name="profileEmail" id="profileEmail" class="form-control"
													 maxlength="64"
													 required [(ngModel)]="profile.profileEmail" #profileEmail="ngModel"/>
										</div>
										<div [hidden]="profileEmail.valid || profileEmail.pristine" class="alert alert-danger"
											  role="alert">
											<p *ngIf="profileEmail.errors?.required">Email is required.</p>
											<p *ngIf="profileEmail.errors?.maxlength">Email is too long.</p>
										</div>
										<div class="form-group"
											  [ngClass]="{ 'has-error': profileZipCode.touched && profileZipCode.invalid }">
											<label for="profileZipCode">Zipcode</label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-user" aria-hidden="true"></i>
												</div>
												<input type="text" name="profileZipCode" id="profileZipCode" class="form-control"
														 maxlength="64" required [(ngModel)]="profile.profileZipCode"
														 #profileZipCode="ngModel"/>
											</div>
											<div [hidden]="profileZipCode.valid || profileZipCode.pristine"
												  class="alert alert-danger"
												  role="alert">
												<p *ngIf="profileZipCode.errors?.required">Zipcode is required.</p>
												<p *ngIf="profileZipCode.errors?.maxlength">Zipcode is too long.</p>
											</div>
											<div class="form-group"
												  [ngClass]="{ 'has-error': profilePassword.touched && profilePassword.invalid }">
												<label for="profilePassword">Password</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-user" aria-hidden="true"></i>
													</div>
													<input type="text" name="profilePassword" id="profilePassword"
															 class="form-control"
															 maxlength="64" required [(ngModel)]="profile.profilePassword"
															 #profilePassword="ngModel"/>
												</div>
												<div [hidden]="profilePassword.valid || profilePassword.pristine"
													  class="alert alert-danger"
													  role="alert">
													<p *ngIf="profilePassword.errors?.required">Password is required.</p>
													<p *ngIf="profilePassword.errors?.maxlength">Password is too long.</p>
												</div>
												<div class="form-group"
													  [ngClass]="{ 'has-error': profilePasswordConfirmation.touched && profilePasswordConfirmation.invalid }">
													<label for="profilePasswordConfirmation">Confirm Password</label>
													<div class="input-group">
														<div class="input-group-addon">
															<i class="fa fa-user" aria-hidden="true"></i>
														</div>
														<input type="text" name="profilePasswordConfirmation"
																 id="profilePasswordConfirmation" class="form-control"
																 maxlength="64" required
																 [(ngModel)]="profile.profilePasswordConfirmation"
																 #profilePasswordConfirmation="ngModel"/>
													</div>
													<div
														[hidden]="profilePasswordConfirmation.valid || profilePasswordConfirmation.pristine"
														class="alert alert-danger" role="alert">
														<p *ngIf="profilePasswordConfirmation.errors?.required">Confirm Password is
															required.</p>
														<p *ngIf="profilePasswordConfirmation.errors?.maxlength">Confirm Password is
															too long.</p>
														<p *ngIf="profilePasswordConfirmation.errors?.value!=profilePassword.value">
															Passwords do not
															match.</p>
													</div>
													<button type="submit" class="btn btn-info btn-lg"
															  [disabled]="signUpForm.invalid"><i
															class="fa fa-share"></i> Submit
													</button>
													<button type="reset" class="btn btn-warning btn-lg"><i class="fa fa-ban"></i>
														Reset
													</button>

													<div *ngIf="status !== null" class="alert alert-dismissible"
														  [ngClass]="status.type" role="alert">
														<button type="button" class="close" aria-label="Close"
																  (click)="status = null;"><span
																aria-hidden="true">&times;</span></button>
														{{ status.message }}
													</div>
												</div>
											</div>
										</div>
									</div>