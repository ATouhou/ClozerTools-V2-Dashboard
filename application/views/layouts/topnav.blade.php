<nav class="navbar user-info-navbar"  role="navigation">
<!-- User Info, Notifications and Menu Bar -->
	<ul class="user-info-menu left-links list-inline list-unstyled">
		<li class="hidden-sm hidden-xs">
			<a class="hideMenuLink" href="#" data-toggle="sidebar">
				<i class="fa-bars"></i>
			</a>
		</li>

		<li class="dropdown hover-line">
		<?php $messages = Auth::user()->received_messages()->take(5)->order_by('created_at','DESC')->get();?>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fa-envelope-o"></i>
				<span class="badge badge-orange ajaxdata-messageCount">@if(count($messages)>0) {{count($messages)}} @endif</span>
			</a>
			<ul class="dropdown-menu messages">
				<li class="ajaxdata-messageList">
					<ul class="dropdown-menu-list list-unstyled ps-scrollbar">
						@foreach($messages as $m)
						<li class="active"><!-- "active" class means message is unread -->
							<a href="#">
								<span class="line">
									<strong>{{$m->sentby->fullName()}}</strong>
									<span class="light small formatDate" data-datetype="relative"> {{strtotime($m->created_at)}}</span>
								</span>
				
								<span class="line desc small">
									{{$m->msg_body}}
								</span>
							</a>
						</li>
						@endforeach
					</ul>
				</li>
				<li class="external">
					<a class="loadPage" href="#mailbox" data-page="{{URL::to('messages')}}">
						<span>All Messages</span>
						<i class="fa-link-ext"></i>
					</a>
				</li>
			</ul>
		</li>
			
		<li class="dropdown hover-line">
		<?php $alerts = Auth::user()->alerts()->take(5)->order_by('created_at','DESC')->get();?>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fa-bell-o"></i>
				<span class="badge badge-purple ajaxdata-alertCount">@if(count($alerts)>0) {{count($alerts)}} @endif</span>
			</a>

			<ul class="dropdown-menu notifications">
				<li class="top">
					<p class="small">
						You have <strong>@if(count($alerts)>0) {{count($alerts)}} @endif</strong> new notifications.
					</p>
				</li>
				
				<li>
					<ul class="dropdown-menu-list list-unstyled ps-scrollbar">
						@foreach($alerts as $a)
						<li class="active notification-{{$a->color}}">
							<a href="#">
								<i class=""><span class='{{$a->icon}}'></span></i>
								<span class="line">
									<strong>{{$a->message}}</strong>
								</span>
								<span class="line small time formatDate" data-datetype="relative">
									{{$a->created_at}}
								</span>
							</a>
						</li>
						@endforeach
					</ul>
				</li>
				
				<li class="external">
					<a href="#">
						<span>View all notifications</span>
						<i class="fa-link-ext"></i>
					</a>
				</li>
			</ul>
		</li>
	</ul>
			
			
	<!-- Right links for user info navbar -->
	<ul class="user-info-menu right-links list-inline list-unstyled">
		<li class="search-form"><!-- You can add "always-visible" to show make the search input visible -->
			<form name="userinfo_search_form" method="get" action="extra-search.html">
				<input type="text" name="s" class="form-control search-field" placeholder="Type to search..." />

				<button type="submit" class="btn btn-link">
					<i class="linecons-search"></i>
				</button>
			</form>
		</li>
			
		<li class="dropdown user-profile">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<img src="{{Auth::user()->avatar_link()}}" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
				<span>
					{{Auth::user()->fullName()}}
					<i class="fa-angle-down"></i>
				</span>
			</a>

			<ul class="dropdown-menu user-profile-menu list-unstyled">
				<li>
					<a href="#edit-profile">
						<i class="fa-edit"></i>
						New Post
					</a>
				</li>
				<li>
					<a href="#settings">
						<i class="fa-wrench"></i>
						Settings
					</a>
				</li>
				<li>
					<a class="loadPage" href="#profile" data-page="{{URL::to('user/profile')}}" >
						<i class="fa-user"></i>
						Profile
					</a>
				</li>
				<li>
					<a href="#help">
						<i class="fa-info"></i>
						Help
					</a>
				</li>
				<li class="last">
					<a href="{{URL::to('users/logout')}}">
						<i class="fa-lock"></i>
						Logout
					</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="#" data-toggle="chat">
				<i class="fa-comments-o"></i>
			</a>
		</li>
	</ul>
</nav>