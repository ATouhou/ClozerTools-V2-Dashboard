@layout('layouts/main')
@section('content')
<h2 class="hidden-xs hidden-sm" style="margin-top:-15px;">
	<img src='{{URL::to("images/clozer-cup.png")}}' class="animated fadeInUp" style="width:66px">
	<b>{{Auth::user()->tenantName()}}</b> - Dashboard
</h2>
<h4 class="hidden-lg hidden-md"><b>{{Auth::user()->tenantName()}}</b> </h4>
	@include('modules.dashboard.grid')
@endsection


