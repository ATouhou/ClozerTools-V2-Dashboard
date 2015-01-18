@layout('layouts/sparse')
@section('content')

<style>
.leaderBoardList {

}

.leaderBoardList li {
	font-size:20px!important;
	font-weight:bolder;
	padding:10px;
}

.leaderBoardLogo {
	width:140px!important;
	margin-top:-10px;
}



</style>

@include('dashboard.stats.salemaps')

<!--
@include('dashboard.stats.leaderboards')
-->

<script>
$(document).ready(function(){

	//var count = $('.filterCompany').length();
	index=0;
	setInterval(

	function(){
		count=10;

		if(index>count){
			index=0;
		} else {
			index++;
		}
		$( '.filterCompany:eq('+index+')' ).trigger('click');
		
	},10000);

	/*$('.filterCompany').each(function(i,val){
		var t =$(this);

		t.trigger('click');
		/*setTimeOut(function(){
			t.trigger('click');
		},1200);




	});*/

	



});

</script>
@endsection