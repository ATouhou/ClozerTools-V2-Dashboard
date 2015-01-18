<h4>Booking Stats for {{$city}}</h4><br/>

<table class='table table-bordered table-condensed' style='margin-bottom:200px;width:90%;'>
<tr>
	<th>Call Count</th>
	<th>Booked</th>
	<th>Not Interested</th>
	<th>Book Ratio</th>
	<th>SOLD</th>
	<th>Close Ratio</th>
</tr>
<?php $book=0;$ni=0;$sold=0;?>
@foreach($stats as $s)
@if($s->assign_count!=0)
@if($s->assign_count<=12)
<?php $ratio=0;$close=0;
$total=$s->booked+$s->notinterested;

if($total!=0){
	$ratio = $s->booked/$total;
};
if($s->sold!=0){
	$closeratio = $s->sold/$total;
} 
?>
<tr>
	<th>{{$s->assign_count}}</th>
	<th><span class='label label-warning blackText special'>{{$s->booked}}</span></th>
	<th><span class='label label-important special'>{{$s->notinterested}}</span></th>
	<th>{{number_format($ratio, 2, '.', ' ')*100}}%</th>
	<th><span class='label label-success blackText special'>{{$s->sold}}</span></th>
	<th>{{number_format($closeratio, 2, '.', ' ')*100}}%</th>
</tr>
@else
<?php $book=$book+$s->booked;$ni=$ni+$s->notinterested;$sold=$sold+$s->sold;?>
@endif
@endif
@endforeach
<!--
@if($book>0)
<tr>
	<th>12 or more</th>
	<th><span class='label label-warning blackText special'>{{$book}}</span></th>
	<th><span class='label label-important special'>{{$ni}}</span></th>
	<th>{{$sold}}</th>
</tr>
@endif
-->
</table>
<div style='height:20px;float:left;width:100%;'></div>
