<?php $modules = GridModule::myModules();?>
<style>
.gridster li {
	list-style:none;
	text-decoration:none;
	border:1px solid #ccc;
}
</style>
<div class="row">
	<button class='btn btn-primary addWidget'>ADD NEW WIDGET</button>
	<button class='btn btn-success saveWidgets'>SAVE LAYOUT</button>
	<button class='btn btn-danger removeWidget'>REMOVE WIDGET</button>
</div>
<div class="row">
	<div class="gridster">
	    <ul>
	    	@foreach($modules as $m)
	        <li data-row="{{$m->data_row}}" data-col="{{$m->data_col}}" data-sizex="{{$m->data_sizex}}" data-sizey="{{$m->data_sizey}}">
	        	{{$m->module_name}}
	        </li>
	      @endforeach
	    </ul>
	</div>
</div>

<script>
$(document).ready(function(){
	$(".gridster ul").gridster({
    	    widget_margins: [5, 5],
    	    widget_base_dimensions: [140, 140],
    	    widget_selector: "li"
    	    
    	});

	var gridster = $(".gridster ul").gridster().data('gridster');
	$('.addWidget').click(function(){
		gridster.add_widget('<li class="new">The HTML of the widget...</li>', 2, 1);
	});

	$('.saveWidgets').click(function(){
		alert(gridster.serialize());
	});

	$('.removeWidget').click(function(){
		gridster.remove_widget($('.gridster li').eq(3));
	});
	
	
 	
    	


});
</script>



