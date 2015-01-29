<ul id="main-menu" class="main-menu">
	<li>
		<a href="{{URL::to('dashboard')}}">
			<i class="linecons-cog"></i>
			<span class="title">Dashboard</span>
		</a>
	</li>
	<li>
		<a href="">
			<i class="linecons-user"></i>
			<span class="title">Leads</span>
		</a>
		<ul>
			<li>
				<a class="loadPage" href="#leads" data-page="{{URL::to('leads')}}">
					<span class="title">Assign Leads</span>
				</a>
			</li>
			<li>
				<a class="loadPage" href="#manageleads" data-page="{{URL::to('leads')}}">
					<span class="title">Manage Leads</span>
				</a>
			</li>
			
			<li>
				<a class="loadPage" href="#leads" data-page="{{URL::to('leads')}}">
					<span class="title">Lead Reports</span>
				</a>
			</li>
		</ul>
	</li>
	<li>
		<a class="loadPage" href="#appointments" data-page="{{URL::to('appointment')}}">
			<i class="linecons-calendar"></i>
			<span class="title">Appointments</span>
		</a>
		
	</li>
	<li>
		<a class="loadPage" href="#" data-page="{{URL::to('reports')}}">
			<i class="linecons-database"></i>
			<span class="title">Reports</span>
		</a>
	</li>
	<li>
		<a href="mailbox-main.html">
			<i class="linecons-mail"></i>
			<span class="title">Mailbox</span>
			<span class="label label-success pull-right">5</span>
		</a>
		<ul>
			<li>
				<a href="mailbox-main.html">
					<span class="title">Inbox</span>
				</a>
			</li>
			<li>
				<a href="mailbox-compose.html">
					<span class="title">Compose Message</span>
				</a>
			</li>
			<li>
				<a href="mailbox-message.html">
					<span class="title">View Message</span>
				</a>
			</li>
		</ul>
	</li>
	<li>
		<a class="loadPage" href="#" data-page="{{URL::to('cities')}}">
			<i class="linecons-city"></i>
			<span class="title">Cities / Areas</span>
		</a>
		<ul>
			<li>
				<a href="tables-basic.html">
					<span class="title">Manage Cities</span>
				</a>
			</li>
		</ul>
	</li>
	<li>
		<a href="forms-native.html">
			<i class="linecons-params"></i>
			<span class="title">Forms</span>
		</a>
		<ul>
			<li>
				<a href="forms-native.html">
					<span class="title">Native Elements</span>
				</a>
			</li>
			<li>
				<a href="forms-advanced.html">
					<span class="title">Advanced Plugins</span>
				</a>
			</li>
			<li>
				<a href="forms-wizard.html">
					<span class="title">Form Wizard</span>
				</a>
			</li>
			<li>
				<a href="forms-validation.html">
					<span class="title">Form Validation</span>
				</a>
			</li>
			<li>
				<a href="forms-input-masks.html">
					<span class="title">Input Masks</span>
				</a>
			</li>
			<li>
				<a href="forms-file-upload.html">
					<span class="title">File Upload</span>
				</a>
			</li>
			<li>
				<a href="forms-editors.html">
					<span class="title">Editors</span>
				</a>
			</li>
			<li>
				<a href="forms-sliders.html">
					<span class="title">Sliders</span>
				</a>
			</li>
		</ul>
	</li>
<ul>