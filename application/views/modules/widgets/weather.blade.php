<div class="row">
	<div class="col-sm-12">
		<div class="xe-widget xe-weather">
			<div class="xe-background xe-background-animated">
				<img src="{{URL::to_asset('assets/')}}images/clouds.png">
			</div>
			<div class="xe-current-day">
				<div class="xe-now">
					<div class="xe-temperature">
						<div class="xe-icon">
							<i class="meteocons-cloud-moon"></i>
						</div>
						<div class="xe-label">
							Now
							<strong>21°</strong>
						</div>
					</div>
					<div class="xe-location">
						<h4>Victoria, BC</h4>
						<time>Today, 06 December</time>
					</div>
				</div>
				<div class="xe-forecast">
					<ul>
						<li>
							<div class="xe-forecast-entry">
								<time>11:00</time>
								<div class="xe-icon">
									<i class="meteocons-sunrise"></i>
								</div>
								<strong class="xe-temp">12°</strong>
							</div>
						</li>
						<li>
							<div class="xe-forecast-entry">
								<time>12:00</time>
								<div class="xe-icon">
									<i class="meteocons-clouds-flash"></i>
								</div>
								<strong class="xe-temp">13°</strong>
							</div>
						</li>
						<li>
							<div class="xe-forecast-entry">
								<time>13:00</time>
								<div class="xe-icon">
									<i class="meteocons-cloud-moon-inv"></i>
								</div>
								<strong class="xe-temp">16°</strong>
							</div>
						</li>
						<li>
							<div class="xe-forecast-entry">
								<time>14:00</time>
								<div class="xe-icon">
									<i class="meteocons-eclipse"></i>
								</div>
								<strong class="xe-temp">19°</strong>
							</div>
						</li>
						<li>
							<div class="xe-forecast-entry">
								<time>15:00</time>
								<div class="xe-icon">
									<i class="meteocons-rain"></i>
								</div>
								<strong class="xe-temp">21°</strong>
							</div>
						</li>
						<li>
							<div class="xe-forecast-entry">
								<time>16:00</time>
								<div class="xe-icon">
									<i class="meteocons-cloud-sun"></i>
								</div>
								<strong class="xe-temp">25°</strong>
							</div>
						</li>
					</ul>
				</div>
			</div>
			
			<div class="xe-weekdays">
				<ul class="list-unstyled">
					<li>
						<div class="xe-weekday-forecast">
							<div class="xe-temp">21°</div>
							<div class="xe-day">Monday</div>
							<div class="xe-icon">
								<i class="meteocons-windy-inv"></i>
							</div>
						</div>
					</li>
					<li>
						<div class="xe-weekday-forecast">
							<div class="xe-temp">23°</div>
							<div class="xe-day">Tuesday</div>
							<div class="xe-icon">
								<i class="meteocons-sun"></i>
							</div>
						</div>
					</li>
					<li>
						<div class="xe-weekday-forecast">
							<div class="xe-temp">19°</div>
							<div class="xe-day">Wednesday</div>
							<div class="xe-icon">
								<i class="meteocons-na"></i>
							</div>
						</div>
					</li>
					<li>
						<div class="xe-weekday-forecast">
							<div class="xe-temp">18°</div>
							<div class="xe-day">Thursday</div>
							<div class="xe-icon">
								<i class="meteocons-windy"></i>
							</div>
						</div>
					</li>
					<li>
						<div class="xe-weekday-forecast">
							<div class="xe-temp">20°</div>
							<div class="xe-day">Friday</div>
							<div class="xe-icon">
								<i class="meteocons-sun"></i>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<!-- TODO - Dynamically load in weather data, based on chosen city -->

