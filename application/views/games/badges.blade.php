
<h4> <b style='color:#000;'>{{$user->profileName()}}</b> Badges / Achievements</h4>
<?php $allGames = $user->achievements("achievements");?>
<div class="autoplay">
        
@if(empty($allGames))
<?php $games = Game::where('user_type','=',$user->user_type)->get();?>
@foreach($games as $game)
	@if($game)
		@if($game->type=="achievements")
			<div class='gameBadge'>
				<center>
					<img class="tooltwo stillLocked  " title="{{$game->game_description}}" src='{{URL::to("img/badges/")}}{{$game->badge_image}}'>
						<div class="locked tooltwo" title="LOCKED"></div>
					<br/>
					<div class='gameName'>
						{{$game->game_name}}
					</div>
				</center>
			</div>
		@endif
	@endif
@endforeach
@endif

@foreach($allGames as $all)
	<?php $game = Game::find($all->game_id);?>
	@if($game)
		@if($game->type=="achievements")
			@if($all->status=="unlocked")
			<div class='gameBadge'>
				<center>
					<img class="tooltwo @if($all->status!="locked") animated fadeInUp @else stillLocked @endif " title="{{$game->game_description}}" src='{{URL::to("img/badges/")}}{{$game->badge_image}}'>
					@if($all->status=="locked")
						<div class="locked tooltwo" title="LOCKED"></div>
					@endif
					@if($all->times_achieved>1)
						<div class="timesAchieved tooltwo animated rollIn" title="{{ucfirst($user->firstname)}} has earned this badge {{$all->times_achieved}} Times">{{$all->times_achieved}}</div>
					@endif
					<br/>
					<div class='gameName'>
						{{$game->game_name}}
					</div>
				</center>
			</div>
			@endif
			
		@endif
	@endif
@endforeach
@foreach($allGames as $all)
	<?php $game = Game::find($all->game_id);?>
	@if($game)
		@if($game->type=="achievements")
			@if($all->status=="locked")
			<div class='gameBadge'>
				<center>
					<img class="tooltwo @if($all->status!="locked") animated fadeInUp @else stillLocked @endif " title="{{$game->game_description}}" src='{{URL::to("img/badges/")}}{{$game->badge_image}}'>
					@if($all->status=="locked")
						<div class="locked tooltwo" title="LOCKED"></div>
					@endif
					@if($all->times_achieved>1)
						<div class="timesAchieved tooltwo animated rollIn" title="{{ucfirst($user->firstname)}} has earned this badge {{$all->times_achieved}} Times">{{$all->times_achieved}}</div>
					@endif
					<br/>
					<div class='gameName'>
						{{$game->game_name}}
					</div>
				</center>
			</div>
			@endif
			
		@endif
	@endif
@endforeach



</div>
<script>
$(document).ready(function(){
          $('.autoplay').slick({
          	width:"95%",
  slidesToShow: 5,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 1400,
});
				
        });
</script>