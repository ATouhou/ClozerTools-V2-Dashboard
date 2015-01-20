<?php $modules = GridModule::myModules();?>
<style>
.item {cursor:pointer;}
#dashboard-container {
	margin-top:20px;
	margin-bottom:30px;
}
.no-gutter [class*="-6"] {
	padding-left:0;
    padding-right:0;
}


.widgetRemove {
	background:#000;
}
</style>
<div class="row">
	<button class='btn btn-primary addWidget'>ADD NEW WIDGET</button>
	<button class='btn btn-success saveWidgets'>SAVE LAYOUT</button>
	<button class='btn btn-danger removeWidget'>REMOVE WIDGET</button>
</div>
<div class="row ">
	<div id="dashboard-container" class="js-packery"
	  data-packery-options='{ "itemSelector": ".item", "gutter": 10 }'>
		@foreach($modules as $m)
			<div class="item col-lg-{{$m->widget->lg_size}} col-sm-{{$m->widget->sm_size}} col-xs-{{$m->widget->xs_size}}" data-id="{{$m->id}}">
				@include($m->widget->widget_template)
			</div>
		@endforeach
	</div>
</div>

<div class="row" style="margin-bottom:40px"></div>
<script>
$(document).ready(function(){
	var $container = $('#dashboard-container');
	//Initialize Packer Grid
	initGrid();
	function initGrid(){
		$container.packery({
		  itemSelector: '.item'
		});
  		$container.find('.item').each( makeEachDraggable );
  		$container.packery( 'on', 'dragItemPositioned', function( pckryInstance, draggedItem ) {
			
		});
	}
	function makeEachDraggable( i, itemElem ) {
    		var draggie = new Draggabilly( itemElem );
    		$container.packery( 'bindDraggabillyEvents', draggie );
  	}

	$('.addWidget').click(function(){
		var id = 1; var sizex=4; var sizey = 2; var row=1; var col = 1;
		$.get('{{URL::to("widget/create")}}',{theid:id,custom_name:"Test"},function(data){
			var elem = "<div class='item col-sm-"+sizex+"'>"+data+"</div>";
			var $items = $(elem);
    			$container.append( $items );
    			$container.packery( 'destroy' );
    			initGrid();
		});
	});

	$('.saveWidgets').click(function(){
		
	});

	$('.removeWidget').click(function(){
		$(".item").addClass('widgetRemove');
	});
	
	$container.on('click','.widgetRemove',function(event){
		var t = confirm("Are you sure you want to remove this widget?");
		if(t){
			var id = $(this).data('id');
			var th = $(this);
			$.get('{{URL::to("widget/remove/")}}',{theid:id},function(data){
				if(data=="success"){
					$container.packery( 'remove', th);
  					$container.packery();
				} 
			});
		} else {
			$(".item").removeClass('widgetRemove');
		}
	});
});
</script>



