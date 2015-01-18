<section class="sidebar-user-info" >
	<div class="sidebar-user-info-inner">
		<a href="extra-profile.html" class="user-profile">
			<img src="{{Auth::user()->avatar_link()}}" width="60" height="60" class="img-circle corona" alt="user-pic" />

			<span>
				<strong>{{Auth::user()->fullName()}}</strong>
				{{ucfirst(Auth::user()->user_type)}}
			</span>
		</a>
		<ul class="user-links list-unstyled">
			<li>
				<a href="extra-profile.html" title="Edit profile">
					<i class="linecons-user"></i>
					Edit profile
				</a>
			</li>
			<li>
				<a href="mailbox-main.html" title="Mailbox">
					<i class="linecons-mail"></i>
					Mailbox
				</a>
			</li>
			<li class="logout-link">
				<a href="{{URL::to('users/logout')}}" title="Log out">
					<i class="fa-power-off"></i>
				</a>
			</li>
		</ul>
	</div>
</section>