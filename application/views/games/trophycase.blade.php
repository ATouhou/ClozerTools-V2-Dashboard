<div style="">
<h3 style="color:#000;">{{$user->profileName()}} Career Highlights</h3>
	<?php $allGames = $user->achievements();?>
	@if(empty($allGames))
	<h4>{{$user->profileName("has")}} not received any trophies / awards </h4>
	@endif
	<?php $cnt=0;$html=array();?>
	@foreach($allGames as $all)
		<?php $game = Game::find($all->game_id);?>
		@if($game)
			@if($game->type=="trophies")
				@if($all->status=="unlocked")
				<?php $cnt++;
				$html[]=htmlentities('<div class="aTrophy tooltwo" title="Unlocked on '.date('M-d Y',strtotime($all->date_achieved)).' originally - Achieved '.$all->times_achieved.' times so far"><img src="'.URL::to('img/badges/').$game->badge_image.'"><br/><span class="label label-warning blackText special" style="margin-left:15px;">Earned '.$all->times_achieved.' times</span></div>');
				?>
				@endif
			@endif
		@endif
	@endforeach
	<?php $shelfcount = ceil($cnt/3);?>
	@for($i=0;$i<$shelfcount;$i++)
	<div class='shelfUnit'>
		<div class='trophyEnd'></div>
		<div class="trophyShelf">
			@for($c=0;$c<=2;$c++)
				@if(isset($html[$c]))
				{{html_entity_decode($html[$c])}}
				@endif

				
				
			@endfor
			<?php unset($html[0]);unset($html[1]);unset($html[2]);
			$html = array_values($html);?>
		</div>
		<div class='trophyEnd right'></div>
		<div class='trophyGlass'></div>
	</div>
	<div class="clearfix" style="background:none;"></div>
	@endfor
</div>
<script>
	$(document).ready(function(){
		$('.tooltwo').tooltipster();
	});
</script>