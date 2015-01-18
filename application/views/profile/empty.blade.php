@layout('layouts/main')
@section('content')
<div id="main" role="main" class="profilePage container-fluid" style="min-height:1800px;">
	<br><br><br>
	<center>
		<h1 style="margin-top:140px;">Loading Profile ... </h1><br/>
		<img src='{{URL::to("img/loaders/misc/300.gif")}}' >
		<!--<img src='{{URL::to("images/cat-vacuum.gif")}}' >-->
	</center>
</div>
<script>
	$(document).ready(function(){
			//setTimeout(function(){$('.profilePage').load("{{$profile}}");},1200);
			$('.profilePage').load("{{$profile}}");
	});
</script>
@endsection
