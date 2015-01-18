@layout('layouts/main')
@section('content')
<input type="hidden" name="user_type" id="user_type" value="{{Auth::user()->user_type}}" />

<h3>{{Auth::user()->tenantName()}}</h3>
<?php 
$appointments = Appointment::take(20)->get();

?>

@foreach($appointments as $a)
	{{$a->lead->address}} - {{$a->lead->cust_num}}<br/>
@endforeach

<script>
$(document).ready(function(){
	var user = $('#user_type').val();
	//$('#ajax-loaded-area').html("Manager Area");
	
});

</script>

@endsection


