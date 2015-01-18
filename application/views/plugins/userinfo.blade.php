<div class="col-md-4">
<div class="user-info">
						
						<div class="user-image">
							<a href="extra-profile.html">
								<img src="{{URL::to_asset('assets/')}}images/user-2.png" class="img-responsive img-circle" />
							</a>
						</div>
						
						<div class="user-details">
							
							<h3>
								<a href="extra-profile.html">{{Auth::user()->fullName()}}</a>
								
								<!-- Available statuses: is-online, is-idle, is-busy and is-offline -->
								<span class="user-status is-online"></span>
							</h3>
							
							<p class="user-title">{{ucfirst(Auth::user()->user_type)}}</p>
							
							<div class="user-links">
								<a href="extra-profile.html" class="btn btn-primary">Edit Profile</a>
								
							</div>
							
						</div>
						
					</div>
				</div>