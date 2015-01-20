@layout('layouts/main')
@section('content')
<input type="hidden" name="user_type" id="user_type" value="{{Auth::user()->user_type}}" />
<div class="row">
<h3>{{Auth::user()->tenantName()}} - Dashboard</h3>
</div>

@include('modules.dashboard.grid')
	

<div class="modal fade" id="dynamic-modal" data-backdrop="static" style="display: none;" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<h4 class="dynamic-modal-title">Dynamic Modal</h4> 
			</div> 
			<div class="dynamic-modal-body">
				You can load the content here
			</div>
 			<div class="modal-footer"> <button type="button" class="btn btn-info" data-dismiss="modal">Continue</button> </div> 
		</div> 
	</div> 
</div>

<script>
$(document).ready(function(){
	var user = $('#user_type').val();
			
});
</script>






@endsection


