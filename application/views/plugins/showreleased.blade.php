<h4>Released Leads for {{$city}} </h4>
<h5>Last 7 Days</h5>
<table class='table table-condensed table-bordered' style='width:90%;'>
	<th>Date</th>
	<th>Door</th>
	<th>Manilla</th>
	<th>Contacted</th>
	<th>Un-Contacted</th>

@foreach($released as $r)
	<tr>
		<td>{{date('M-d',strtotime($r->release_date))}}</td>
		<td>{{$r->doorreleased}}</td>
		<td>{{$r->paperreleased}}</td>
		<td>{{$r->contacted}}</td>
		<td>{{$r->uncontacted}}</td>
		

</tr>
@endforeach
</table><br/><br/>