@layout('layouts/main')
@section('content')
<input type="hidden" name="user_type" id="user_type" value="{{Auth::user()->user_type}}" />

<h3>{{Auth::user()->tenantName()}}</h3>
<?php 
$modules = array("modules.widgets.portlets","modules.appointments.board","modules.widgets.weather","modules.widgets.sales");
?>
@include('modules.dashboard.grid')

@foreach($modules as $m)
	@include($m)
@endforeach
			

<script>
$(document).ready(function(){
	var user = $('#user_type').val();

});
</script>

<script type="text/javascript">
	$(document).ready(function()
	{
		var $draggable_portlets = $(".draggable-portlets");

		$(".draggable-portlets .sorted" ).sortable({
			connectWith: ".draggable-portlets .sorted",
			handle: '.panel-heading',
			containment: 'window',
			start: function()
			{
				$draggable_portlets.addClass('dragging');
			},
			stop: function()
			{
				$draggable_portlets.removeClass('dragging');
			}
		});

		$( ".draggable-portlets .sorted .panel-heading" ).disableSelection();

	});
</script>


@endsection


