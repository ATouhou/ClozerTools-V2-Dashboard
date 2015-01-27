<?php $modules = GridModule::myModules();?>
<style>

.item {cursor:pointer;float: left;}
.item.is-dragging,
.item.is-positioning-post-drag {
  border-color: white;
  z-index: 2;
}
#dashboard-container {
	margin-top:20px;
	margin-bottom:30px;
}
.widgetRemove {
	background:#000;
}
.no-padding {
	padding:0px!important;
}
</style>
<div class="row hidden-xs hidden-sm">
	<button class='btn btn-xs btn-primary refreshStats'>Refresh Data</button>
	<button class='btn btn-xs btn-primary addWidget'>AAdd New Widget</button>
	<button class='btn btn-xs btn-success saveWidgets'>SAVE </button>
	<button class='btn btn-xs btn-danger removeWidget'>Remove Widget</button>
</div>
<div class="row ">
	<div id="dashboard-container" >
		@foreach($modules as $m)
			<?php 
			if($m->custom_lg!=0){$lg=$m->custom_lg;} else {$lg=$m->widget->lg_size;};
			if($m->custom_sm!=0){$sm=$m->custom_sm;} else {$sm=$m->widget->sm_size;};
			if($m->custom_md!=0){$md=$m->custom_md;} else {$md=$m->widget->md_size;};
			if($m->custom_xs!=0){$xs=$m->custom_xs;} else {$xs=$m->widget->xs_size;};?>

			<div class="item no-padding col-lg-{{$lg}} col-sm-{{$sm}} col-xs-{{$xs}}" data-widgetid="{{$m->widget->id}}" data-id="{{$m->id}}" tabindex="{{$m->id}}">
				@include($m->widget->widget_template)
			</div>
		@endforeach
	</div>
</div>

<div class="row" style="margin-bottom:40px"></div>
<script>
$( function() {
  	var $container = $('#dashboard-container').packery({
    		isInitLayout: false
  	});

  	var pckry = $container.data('packery');
  	var sortOrder = []; // global variable for saving order, used later
  	var storedSortOrder = localStorage.getItem('sortOrder');
  	if ( storedSortOrder ) {
  	  storedSortOrder = JSON.parse( storedSortOrder );
  	  // create a hash of items by their tabindex
  	  var itemsByTabIndex = {};
  	  var tabIndex;
  	  for ( var i=0, len = pckry.items.length; i < len; i++ ) {
  	    var item = pckry.items[i];
  	    tabIndex = $( item.element ).attr('tabindex');
  	    itemsByTabIndex[ tabIndex ] = item;
  	  }
  	  // overwrite packery item order
  	  i = 0; len = storedSortOrder.length;
  	  for (; i < len; i++ ) {
  	    tabIndex = storedSortOrder[i];
  	    pckry.items[i] = itemsByTabIndex[ tabIndex ];
  	  }
  	}

  	// ----- packery setup ----- //
  	// trigger initial layout
  	function initGrid(){
  		$container.packery({ "gutter": 15 });
  	}
  	initGrid();
  	
  	var itemElems = $container.packery('getItemElements');
  	$( itemElems ).each( function( i, itemElem ) {
  	  var draggie = new Draggabilly( itemElem );
  	  $container.packery( 'bindDraggabillyEvents', draggie );
  	});
  	// ----- setup draggabilly events ----- //
  	function orderItems() {
  	var itemElems = pckry.getItemElements();
  	  sortOrder.length = 0;
  	  for (var i=0; i< itemElems.length; i++) {
  	    sortOrder[i] = itemElems[i].getAttribute("tabindex");
  	  }
  	  localStorage.setItem('sortOrder', JSON.stringify(sortOrder) );
  	}

  	$container.packery( 'on', 'layoutComplete', orderItems );
  	$container.packery( 'on', 'dragItemPositioned', orderItems );
  	
  	// Refresh widgets button
  	$('.refreshStats').click(function(){
		refreshStats();
	});

	//Hide Menu re-pack
	$('.hideMenuLink').click(function(){
  		setTimeout(initGrid,122);
	});

	function refreshStats(){
		$.getJSON("{{URL::to('api/salestats/MONTH')}}",function(data){
			localStorage.setItem('tenantStats_MONTH', JSON.stringify(data));
			toastr.success("Retrieved New Monthly Data!","MONTHLY DATA RETRIEVED");
		});
		$.getJSON("{{URL::to('api/salestats/WEEK')}}",function(data){
			localStorage.setItem('tenantStats_WEEK', JSON.stringify(data));
			toastr.success("Retrieved New Weekly Data!","WEEKLY DATA RETRIEVED");
		});
		$.getJSON("{{URL::to('api/salestats/ALLTIME')}}",function(data){
			localStorage.setItem('tenantStats_ALLTIME', JSON.stringify(data));
			toastr.success("Retrieved New All Time Data!","ALL TIME DATA RETRIEVED");
		});
		loadWidgets();
	}

	if (localStorage.getItem("tenantStats_ALLTIME") === null) {
		$.getJSON("{{URL::to('api/salestats/ALLTIME')}}",function(data){
			localStorage.setItem('tenantStats_ALLTIME', JSON.stringify(data));
		});
	} 
	if (localStorage.getItem("tenantStats_MONTH") === null) {
		$.getJSON("{{URL::to('api/salestats/MONTH')}}",function(data){
			localStorage.setItem('tenantStats_MONTH', JSON.stringify(data));
		});
	} 
	if (localStorage.getItem("tenantStats_WEEK") === null) {
		$.getJSON("{{URL::to('api/salestats/WEEK')}}",function(data){
			localStorage.setItem('tenantStats_WEEK', JSON.stringify(data));
		});
	} 
	loadWidgets();

	function loadWidgets(){
		$('.widgetDataPoint').each(function(){
			$(this).removeClass('animated fadeInUp').hide();
			var dataPoint = $(this).data('key').split('.');
			var object = $(this).data('statobject');
			var obj = JSON.parse(localStorage.getItem("tenantStats_"+object));
			if(dataPoint.length<=1){
				var dat = obj[object][dataPoint[0]];
			} else if(dataPoint.length==2){
				var dat = obj[object][dataPoint[0]][dataPoint[1]];
			} else if(dataPoint.length==3){
				var dat = obj[object][dataPoint[0]][dataPoint[1]][dataPoint[2]];	
			} else if(dataPoint.length==4){
				var dat = obj[object][dataPoint[0]][dataPoint[1]][dataPoint[2]][dataPoint[3]];	
			}
			if($(this).hasClass('progress-bar')){
				console.log(dat);
				$(this).css('width',dat/100+'%').show();
			} else if($(this).hasClass('guageChart')){
				$(this).show();
			}
			else {
				$(this).html(dat).addClass('animated fadeInUp').show();
			}
			
		});
	}	

	$('.addWidget').click(function(){
		$('#dynamic-modal').modal({backdrop:'static'});
		$('.dynamic-modal-title').html("Add a New Widget");
		$('.modalButtonHTML').html("ADD THIS WIDGET").hide();
		$('.dynamic-modal-body').load("{{URL::to('widget/addnewwidget')}}");
	});

	$('.saveWidgets').click(function(){
		
	});

	$('.removeWidget').click(function(){
		$(".item").addClass('widgetRemove animated pulse');
	});
	
	$container.on('click','.widgetRemove',function(event){
		var t = confirm("Are you sure you want to remove this widget?");
		if(t){
			var id = $(this).data('id');
			var th = $(this);
			$.get('{{URL::to("widget/remove/")}}',{theid:id},function(data){
				if(data=="success"){
					$container.packery( 'remove', th);
  					initGrid();
  					//toastr.success("Removed Widget Successfully","Removed Widget");
				} 
			});
		} else {
			$(".item").removeClass('widgetRemove');
		}
	});
});
</script>






