@layout('layouts/main')
@section('content')
<input type="hidden" name="user_type" id="user_type" value="{{Auth::user()->user_type}}" />
<div class="row">
<h3>{{Auth::user()->tenantName()}} - Dashboard</h3>
</div>
<?php 
$modules = array("modules.appointments.board","modules.widgets.weather","modules.widgets.sales");
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




@endsection


