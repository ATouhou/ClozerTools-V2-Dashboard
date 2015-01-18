<style>
.previewTable {
	
	margin:0px;padding:0px;
	width:95%;
	box-shadow: 10px 10px 5px #888888;
	border:1px solid #000000;
	
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
	
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
	
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
	
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}.previewTable table{
    border-collapse: collapse;
        border-spacing: 0;
	width:100%;
	height:100%;
	margin:0px;padding:0px;
	font-size:26px!important;
}.previewTable tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.previewTable table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.previewTable table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.previewTable tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}.previewTable tr:hover td{
	
}

.previewTable td{
	vertical-align:middle;
	
	
	border:1px solid #000000;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:2px;
	font-size:17px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.previewTable tr:last-child td{
	border-width:0px 1px 0px 0px;
}.previewTable tr td:last-child{
	border-width:0px 0px 1px 0px;
}.previewTable tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.previewTable tr.header td{
		background:-o-linear-gradient(bottom, #666666 5%, #666666 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #666666), color-stop(1, #666666) );
	background:-moz-linear-gradient( center top, #666666 5%, #666666 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#666666", endColorstr="#666666");	background: -o-linear-gradient(top,#666666,666666);

	background-color:#666666;
	border:0px solid #000000;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:20px;
	font-family:Arial;
	font-weight:bolder!important;
	color:#ffffff;
}

.previewTable tr.header2 td{
	
	background-color:#3e3e3e;
	border:0px solid #000000;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:18px;
	font-family:Arial;

	color:#ffffff;
}
.previewTable tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #666666 5%, #666666 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #666666), color-stop(1, #666666) );
	background:-moz-linear-gradient( center top, #666666 5%, #666666 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#666666", endColorstr="#666666");	background: -o-linear-gradient(top,#666666,666666);

	background-color:#666666;
}
.previewTable tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.previewTable tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}
body {font-size:15px;font-family:Arial;}
</style>
@if(!empty($sales))
<div style="padding:30px;margin:0 auto;width:100%;float:left;">
	<h1>Sold Appointments Report For {{date('M-d Y',strtotime($date))}}</h1>
	<br/><br/>
	
	@foreach($agents as $agent)
		@if(isset($sales[$agent->id]))
		<h2>{{$agent->fullName()}} 
			<a href="{{URL::to('reports/soldapps?startdate=')}}{{$date}}&booker-id={{$agent->id}}" target=_blank >
				<button style="padding:5px;font-size:17px;">PRINT PDF</button>
			</a>
		</h2>
		<table class="previewTable">
			<tr>
				<td>Customer Name</td><td>Number</td><td>Address</td><td>City </td>
				<Td>Sale Type</td>
				<td>Status</td>
				<td>Booker</td>
			</tr>
			
			@foreach($sales[$agent->id] as $s)
				
				<tr>
					<td><b>{{strtoupper($s->cust_name)}}</b></td>
					<td>{{$s->lead->cust_num}}</td>
					<td>{{$s->lead->address}}</td>
					<td>{{$s->lead->city}}</td>
					<td><img src='{{URL::to("images/pureop-small-")}}{{$s->typeofsale}}.png' style="height:28px;">&nbsp; {{strtoupper($s->typeofsale)}} </td>
					<td>{{strtoupper($s->status)}}</td>
					<td><b>{{User::find($s->booker_id)->fullName()}}</b></td>
				</tr>
				
			@endforeach
			
		</table>
		<br/><br/>
		@endif
	@endforeach
	</div>
@else
<br><br><br>
<center>
<h1>There are no Sales for {{date('M-d Y',strtotime($date))}}</h1>
</center>
@endif