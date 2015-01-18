@if(Setting::find(1)->daily_snapshot==1 && Auth::user()->user_type=="manager")
<a href="{{URL::to('reports/dailysnapshot')}}?startdate={{$startdate}}&enddate={{$enddate}} ">
	<button class="btn btn-default right-button smallShadow">
		<i class="cus-camera"></i>&nbsp;DAILY SNAP
	</button>
</a>
@endif

@if(Auth::user()->user_type=="manager")
<a href="{{URL::to('reports/dataentry')}}?startdate={{$startdate}}&enddate={{$enddate}} ">
	<button class="btn btn-default right-button smallShadow">
		<i class="cus-computer"></i>&nbsp;MANILLA REPORT
	</button>
</a>

<a href="{{URL::to('reports/other')}}?leadtype_get=all&startdate={{$startdate}}&enddate={{$enddate}}">
	<button class="btn btn-default right-button smallShadow">
		<i class="cus-ticket"></i>&nbsp;OTHER
	</button>
</a>

<a href="{{URL::to('reports/door')}}?startdate={{$startdate}}&enddate={{$enddate}}">
	<button class="btn btn-default right-button smallShadow">
		<i class="cus-door-in"></i>&nbsp;DOOR REG
	</button>
</a>

<a href="{{URL::to('reports/marketing')}}?startdate={{$startdate}}&enddate={{$enddate}}">
	<button class="btn btn-default right-button smallShadow">
		<i class="cus-telephone"></i>&nbsp;MARKETING
	</button>
</a>

<a href="{{URL::to('reports/sales')}}?startdate={{$startdate}}&enddate={{$enddate}}">
	<button class="btn btn-default right-button smallShadow">
		<i class="cus-money-dollar"></i>&nbsp;SALES
	</button>
</a>


<a href="{{URL::to('sales/invoice')}}?startdate={{$startdate}}&enddate={{$enddate}}">
	<button class="btn btn-default right-button smallShadow">
		<i class="cus-money"></i>&nbsp;INVOICES
	</button>
</a>
@endif
<br/>
@if(Auth::user()->user_type=="manager")
&nbsp;&nbsp;
        <button class='tooltwo btn btn-warning blackText oneTouchReports ' data-start="{{$startdate}}" data-end="{{$enddate}}" title="Click to download all reports for chosen period. (Marketing, Sales Journal, Sales Report, Healthmor Excel etc)" style='font-size:16px;color:#fff;margin-left:-14px;padding:6px;border-radius:5px;'>
            <i class='cus-doc-excel-table'></i>
            &nbsp;&nbsp;<b>ONE CLICK REPORTS</b>
        </button>
@endif