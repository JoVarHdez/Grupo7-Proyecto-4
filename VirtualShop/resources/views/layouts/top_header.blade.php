	<!-- top-header -->
	<div class="agile-main-top">
		<div class="container-fluid">
			<div class="row main-top-w3l py-2">
				<div class="col-lg-4 header-most-top">
					<p class="text-white text-lg-left text-center">
						@if (Auth::check())
							Welcome {{ Auth::user()-> email}}
						@else
							Start Shopping Today
						@endif
						<i class="fas fa-shopping-cart ml-1"></i>
					</p>
				</div>

				<div class="col-lg-8 header-right mt-lg-0 mt-2">
					<!-- header lists -->
					<ul>
						<li class="text-center border-right text-white">
							
						</li>
						<li class="text-center border-right text-white">
							
						</li>
						<li class="text-center border-right text-white">
							
						</li>

						@if (Auth::check())
			            	
			            	<li class="text-center border-right text-white">
			            		<a href="/order/{{ Auth::user()->idUser }}" class="text-white"><i class="fas fa-archive mr-2"></i>{{ Auth::user()->name }}'s orders</a>
							</li>
							<li class="text-center border-right text-white">
			            		<a href="/logout" class="text-white"><i class="fas fa-sign-in-alt mr-2"></i>Log Out</a>
							</li>
			            @else
			            	<li class="text-center border-right text-white">
								<a href="#" data-toggle="modal" data-target="#exampleModal" class="text-white">
									<i class="fas fa-sign-in-alt mr-2"></i> Log In </a>
							</li>
							<li class="text-center text-white">
								<a href="#" data-toggle="modal" data-target="#exampleModal2" class="text-white">
									<i class="fas fa-sign-out-alt mr-2"></i> Register </a>
							</li>
			            @endif

						
					</ul>
					<!-- //header lists -->
				</div>
			</div>
		</div>
	</div>
	<!-- modals -->
	<!-- log in -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center">Log In</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<form action="/login" method="post">

						{{ csrf_field() }}
						
						<div class="form-group">
							<label for="email" class="col-form-label">Email</label>
							<input type="text" class="form-control" placeholder="email@example.com" name="email" dusk="login-email-input" required>
						</div>
						<div class="form-group">
							<label for="password" class="col-form-label">Password</label>
							<input type="password" class="form-control" name="password"  dusk="login-password-input" required>
						</div>
						<div class="right-w3l">
							<input type="submit" class="form-control" value="Log in" dusk="login-button">
							<!-- <button type="submit" class="btn btn-primary">Log in</button> -->
						</div>
						<p class="text-center dont-do mt-3">Don't have an account?
							<a href="#" data-toggle="modal" data-target="#exampleModal2">
								Register Now</a>
						</p>
					</form>

				</div>
			</div>
		</div>
	</div>
	<!-- register -->
	<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Register</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="/register" method="post">
						{{ csrf_field() }}
						
						<div class="form-group">
							<label class="col-form-label" for="name">Your Name</label>
							<input type="text" class="form-control" placeholder="Name" name="name" dusk="register-name-input" required>
						</div>
						<div class="form-group">
							<label class="col-form-label" for="email">Email</label>
							<input type="email" class="form-control" placeholder="email@example.com" name="email" dusk="register-email-input" required>
						</div>
						<div class="form-group">
							<label class="col-form-label" for="password">Password</label>
							<input type="password" class="form-control" name="password" id="password" dusk="register-password-input" required>
						</div>
						<div class="form-group">
							<label class="col-form-label" for="password_confirmation">Confirm Password</label>
							<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" dusk="register-password_confirmation-input" required>
						</div>
						<div class="right-w3l">
							<input type="submit" class="form-control" value="Register"  dusk="register-button">
						</div>
						<div class="sub-w3l">
							<div class="custom-control custom-checkbox mr-sm-2">
								<input type="checkbox" class="custom-control-input" id="terms_and_conditions" name="terms_and_conditions">
								<label class="custom-control-label" for="terms_and_conditions" dusk="agree">I Accept to the Terms & Conditions</label>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- //modal -->
	<!-- //top-header -->