<div class="row">
	<form role="form">
		{{print_r($myWidgets)}}
		<div class="form-group"> 

			<script type="text/javascript">
			$(document).ready(function($)
			{	$container = $('#dashboard-container');
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

				

				$('input.icheck-11').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-yellow'
				});

				$('input.icheck-11').on('ifChecked', function(event){
					var lg = $(this).data('lgsize');var sm = $(this).data('smsize');var med = $(this).data('medsize');
					var xs = $(this).data('xssize'); var id = $(this).data('widgetid');
					$.get('{{URL::to("widget/create")}}',{theid:id,custom_name:"Test"},function(data){
						var elem = "<div class='item col-sm-"+sm+" col-lg-"+lg+" col-med-"+med+" col-xs-"+xs+"' data-widgetid='"+id+"'>"+data+"</div>";
						var $items = $(elem);
    						$container.append( $items );
    						$container.packery( 'destroy' );
    						initGrid();
					});
				});
				$('input.icheck-11').on('ifUnchecked', function(event){
  					
				});
			});
			</script> 
		
			
	
		<ul class="icheck-list">
		    @foreach($widgets as $w)
			     <?php if(in_array($w->id, $myWidgets)){$checked = "checked=checked";} else {$checked="";};?>
				<li class="widgetItem">
		      	  	<input type="checkbox" class="icheck-11 addRemoveWidget" id="widget-id-{{$w->id}}" data-widgetid="{{$w->id}}" data-lgsize="{{$w->lg_size}}" data-smsize="{{$w->sm_size}}" data-medsize="{{$w->med_size}}" data-xssize="{{$w->xs_size}}" {{$checked}} >
		      	  	<label for="minimal-checkbox-1-11">{{$w->widget_name}}</label>
		    		</li>
			@endforeach
		</ul>
		</div>
	</form>
</div>
