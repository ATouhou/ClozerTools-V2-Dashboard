 @if(Setting::find(1)->office_access==1 || $viewMyself==true)

<div class="row-fluid" style="height:30px;margin-top:40px;"></div>
<br/><br/>
  @if(empty($all))
<div class="specialistbox animated fadeInUp" id="rep-{{$user->id}}" style="margin-left:22px;margin-top:28px;" >

    <div class="span7">
    <h4 style="margin-top:0px;">{{$user->fullName()}} </h3>
        <span class='label label-inverse'>LEVEL : {{$user->level}}</span>
        <img src="{{URL::to_asset('images/')}}level{{$user->level}}.png" style="margin-left:20px;" width=40px><br/><br/>
        <span class="label label-success special" style="margin-bottom:7px;">{{$user->weekssales()}} UNITS </span>&nbsp;This Week<br/>
        <span class="label label-info special" style="margin-bottom:7px;">{{$user->monthssales()}} UNITS </span>&nbsp;This Month<br/>
        <?php $cn = $user->demosSince();
        if($cn['count']>3){
            $label="important";
        } else if($cn['count']<3) {
            $label="success";
        } else {
            $label="info";
        };
        ?>
        <span class="label label-{{$label}} special" style="margin-bottom:7px;"> {{$cn['count']}} </span>&nbsp;Demos Since Last<br/><br/>
        @if($viewMyself==true)
        <button class='btn btn-primary btn-small' onclick="$('.employeeNotes').toggle();">SEE EMPLOYEE NOTES</button>
        @endif
    </div>
    <div class="span4">
    @if($viewMyself==true)
        <a href='{{URL::to("users/viewprofile/")}}{{$user->id}}'>
            <img class=" avatar animated rollIn" src="{{$user->avatar_link()}}" data-id='{{$user->id}}' style="border-radius:14px;">
        </a>
    @else
        <img class=" avatar animated rollIn" src="{{$user->avatar_link()}}" data-id='{{$user->id}}' style="border-radius:14px;">
    @endif
         
    </div>
</div>
@endif
	
<div class="span7" style="margin-top:10px;">
	<div class="span4 border-right">
		<center>
			<h5>Average Time in Demo</h5>
		<h2 style="color:#000;">{{$stats['averagetime']['avg']}}</h2>
			<h4 class="label label-success">Average Time in Sale</h4>
		<h4 style="color:#000;margin-top:-2px;">{{$stats['averagetime']['sold']}}</h4>
			<h5 class="label label-important" >Average Time in DNS</h5>
		<h4 style="color:#000;margin-top:-2px;">{{$stats['averagetime']['dns']}}</h4>
		</center>
	</div>
	<!--<div class="span5 border-right">
		<div id="monthbalancechart" style=" height: 230px;"></div>
	</div>-->

    @if($user)
    <?php $systemPoints = $user->achievements('main');?>
    <div class="span5">
        <h4>Career Achievements</h4>
        @if($systemPoints)
            @foreach($systemPoints as $u)
                <img src='{{URL::to("img/badges/")}}{{strtolower($u->css_class())}}.png' style='width:35px;margin-bottom:8px;'>
                <span class='tooltwo badge {{$u->css_class()}} blackText ' title='{{$u->game->game_description}}'>{{$u->points}} {{$u->game_name}}</span><br/>
            @endforeach
        @endif
    </div>



    @endif
</div>
  
	@if($type!="all")
    <div class="row-fluid employeeNotes" style="display:none;">
        <div class="span12" style='padding:30px;'>
            <button class='btn btn-default addUserNote' data-userid="{{$user->id}}"><i class='cus-note'></i>&nbsp;&nbsp;ADD A NEW NOTE / COMMENT</button><br/><br/>
            

            <table class='table table-condensed table-bordered'>
                <tr>
                    <th>Entered By</th>
                    <th style="width:60%;">Comment / Note</th>
                    <th>Date Entered</th>
                    <th>Delete</th>
                </tr>
                <tbody class='user-note-table'>
                @foreach($notes as $n)
                <tr id='userNoteRow-{{$n->id}}'>
                    <td>{{User::find($n->sender_id)->firstname}} {{User::find($n->sender_id)->lastname}}</td>
                    <td>{{$n->body}}</td>
                    <td>{{date('Y-m-d',strtotime($n->created_at))}}</td>
                    <td><button class='btn btn-mini btn-danger deleteUserNote' data-id='{{$n->id}}'>X</button></td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <br/><br/>
        </div>
    </div>
    @endif

	<div class="row-fluid" style="float:left;width:100%;margin-top:25px;">

		  <?php $num = cal_days_in_month(CAL_GREGORIAN, 5, 1979) ; 
        		$date =  date('1-m-Y',strtotime('this month'));
        		$c=-1;$q=1;?>

         		<div class="span12" style="padding-left:25px;padding-right:25px;">
		<table class="table table-bordered table-condensed dateTable" >
            	      <tr style="background:black;color:#fff; font-size:10px;">
            	        @for($i=1;$i<=7;$i++)
        				<?php $q++;?>
        				<th style="width:10%;">{{date('D d',strtotime($date. ' + '.$q.' days'))}}</th>
		        		@endfor
            	      </tr>
            	      <tr >
					@for($i=1;$i<=7;$i++)
					<?php $c++;?>
            	            <td height=65px>
            	            	@foreach($sales as $s)
                                
            	            		@if($s->date==date('Y-m-d',strtotime($date.'+'.$c.' days')))
                                    
            	            		@if($s->typeofsale=="2defenders")
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
            	            		@elseif($s->typeofsale=="3defenders")
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
            	            		@else
            	            		<img class="tooltwo littleProduct {{$s->status}}-sale" title="{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}" src='{{URL::to_asset("images/pureop-")}}{{$s->typeofsale}}.png' >
            	            		@endif
                                    
            	            		@endif
                                
            	            	@endforeach
            	            </td>
            	            @endfor
            	      </tr>
            	      <tr style="background:black;color:#fff;font-size:10px;">
            	            @for($i=8;$i<=14;$i++)
        				<?php $q++;?>
        				<th style="width:10%;">{{date('D d',strtotime($date. ' + '.$q.' days'))}}</th>
		        		@endfor
            	      </tr>
            	      <tr >
					@for($i=8;$i<=14;$i++)
					<?php $c++;?>
            	            <td height=65px >
            	            	@foreach($sales as $s)
            	            		@if($s->date==date('Y-m-d',strtotime($date.'+'.$c.' days')))
                                   
            	            		@if($s->typeofsale=="2defenders")
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
            	            		@elseif($s->typeofsale=="3defenders")
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}defender.png' >
            	            		@else
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-")}}{{$s->typeofsale}}.png' >
            	            		@endif
                               
            	            		@endif
            	            	@endforeach
            	            </td>
            	            @endfor
            	      </tr>
            	      <tr style="background:black;color:#fff;font-size:10px;">
            	       @for($i=15;$i<=21;$i++)
        				<?php $q++;?>
        				<th style="width:10%;">{{date('D d',strtotime($date. ' + '.$q.' days'))}}</th>
		        		@endfor
            	      </tr>
            	      <tr >
					@for($i=15;$i<=21;$i++)
					<?php $c++;?>
            	            <td height=65px >
            	            	@foreach($sales as $s)
            	            		@if($s->date==date('Y-m-d',strtotime($date.'+'.$c.' days')))
                                   
            	            		@if($s->typeofsale=="2defenders")
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
            	            		@elseif($s->typeofsale=="3defenders")
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
            	            		@elseif($s->typeofsale=="2maj")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @elseif($s->typeofsale=="3maj")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @else
            	            		<img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}{{$s->typeofsale}}.png' >
            	            		@endif
                      
            	            		@endif
            	            	@endforeach
            	            </td>
            	            @endfor
            	      </tr>
                       <tr style="background:black;color:#fff;font-size:10px;">
                            @for($i=23;$i<=29;$i++)
                        <?php $q++;?>
                        <th style="width:10%;">{{date('D d',strtotime($date. ' + '.$q.' days'))}}</th>
                        @endfor
                      </tr>
                      <tr >
                    @for($i=23;$i<=29;$i++)
                    <?php $c++;?>
                            <td height=65px >
                                @foreach($sales as $s)
                                    @if($s->date==date('Y-m-d',strtotime($date.'+'.$c.' days')))
                                   
                                    @if($s->typeofsale=="2defenders")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @elseif($s->typeofsale=="3defenders")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @elseif($s->typeofsale=="2maj")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @elseif($s->typeofsale=="3maj")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @else
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}{{$s->typeofsale}}.png' >
                                    @endif
                               
                                    @endif
                                @endforeach
                            </td>
                            @endfor
                      </tr>
                      <tr style="background:black;color:#fff;font-size:10px;">
                            @for($i=31;$i<=32;$i++)
                        <?php $q++;?>
                        <th style="width:10%;">{{date('D d',strtotime($date. ' + '.$q.' days'))}}</th>
                        @endfor
                      </tr>
                      <tr >
                    @for($i=31;$i<=32;$i++)
                    <?php $c++;?>
                            <td height=65px >
                                @foreach($sales as $s)
                                    @if($s->date==date('Y-m-d',strtotime($date.'+'.$c.' days')))
                                   
                                    @if($s->typeofsale=="2defenders")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @elseif($s->typeofsale=="3defenders")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}defender.png' >
                                    @elseif($s->typeofsale=="2maj")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @elseif($s->typeofsale=="3maj")
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}majestic.png' >
                                    @else
                                    <img class='tooltwo littleProduct {{$s->status}}-sale' title='{{$s->payment}} | {{$s->status}} | Sold to : {{$s->lead->cust_name}} | Sold By : {{$s->sold_by}}' src='{{URL::to_asset("images/pureop-small-")}}{{$s->typeofsale}}.png' >
                                    @endif
                              
                                    @endif
                                @endforeach
                            </td>
                            @endfor
                      </tr>
            	    </table>
	</div>
	<div class="row-fluid" style="float:left;margin-top:30px;">
	


		<div class="span4 border-right">
			<div id="grossdefenderschart" style=" height: 290px;margin-left:10px; margin-top:20px;"></div><br/>
			<div id="netdefenderschart" style=" height: 290px;margin-left:10px; margin-top:20px;"></div>
		</div>
		<div class="span4 border-right">
			<div id="grossmajesticschart" style=" height: 290px;margin-left:10px; margin-top:20px;"></div><br/>
			<div id="netmajesticschart" style=" height: 290px;margin-left:10px; margin-top:20px;"></div>
		</div>
		
		<div class="span3  " style="padding-top:5px;">
		<div id="system" style="width:100%; height: 220px; "></div><br/>
		<div id="asthma" style="width:100%; height: 220px; "></div><br/>
		<div id="fullpart" style="width:100%; height: 220px; "></div><br/>
		</div>
		
	</div>
	
</div>




<div class="row-fluid">
	<div class="span12">
		<div class="span6 well">
			<div id="totbalancechart" style=" height: 350px;margin-left:10px; margin-top:20px;"></div>
		</div>
		<div class="span6 well">
			<div id="bookpie" style="width:100%; height: 370px; "></div>
		</div>
		
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
	<div id="container" style="width:100%; height: 290px;margin-left:10px; margin-top:40px;"></div>
	</div>
</div>
<div class="row-fluid">
	<div class="span6 well" >
		<div id="timesold" style="width:100%; height: 350px; "></div>
	</div>
	<div class="span6 well">
		<div id="timedns" style="width:100%; height: 350px;"></div>
	</div>

</div>
</div>

		

<script>
$(document).ready(function(){
        $('.tooltwo').tooltipster();

        $('#container').highcharts({
            chart: {
                type: 'column'
            },exporting: {
         enabled: false
		},
            title: {
                text: 'Appointment Result History This Month'
            },
          
            xAxis: {
                categories: 
                  {{json_encode($stats['saledata']['date'])}}
                
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Appointments'
                }
            },
            tooltip: {
                headerFormat: '<table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:1f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'DNS',
                data: {{json_encode($stats['saledata']['dns'])}},
                color:'red'
    
            }, {
                name: 'SOLD',
                data: {{json_encode($stats['saledata']['sold'])}},
                 color:'lime'
    
            }, {
                name: 'INC',
                data: {{json_encode($stats['saledata']['inc'])}},
                 color:'orange'
    
            }]
        });


    $('#timesold').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },exporting: {
         enabled: false
		},
        title: {
            text: 'SOLD Time Breakdown'
        },
       
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                  
                }
            }
        },
        series: [{
            type: 'pie',
            data: 
                {{json_encode($stats['sold'])}},
            
        }]
    });

    $('#timedns').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },exporting: {
         enabled: false
		},
        title: {
            text: 'DNS Time Breakdown'
        },
       
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                  
                }
            }
        },
        series: [{
            type: 'pie',
            data: 
                {{json_encode($stats['dns'])}},
            
        }]
    });

     $('#system').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },exporting: {
         enabled: false
		},
        title: {
            text: 'Sale by Leadtype'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            data: 
                {{json_encode($stats['leadtype'])}},
            
        }]
    });

      $('#asthma').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },exporting: {
         enabled: false
		},
        title: {
            text: 'HAD ASTHMA'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            data: 
                {{json_encode($stats['asthmapie'])}},
            
        }]
    });

       $('#fullpart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },exporting: {
         enabled: false
		},
        title: {
            text: 'FT/PT'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            data: 
                {{json_encode($stats['fullpartpie'])}},
            
        }]
    });

       $('#bookpie').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },exporting: {
         enabled: false
		},
        title: {
            text: 'Breakdown of Sales By Booker'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            data: 
                {{json_encode($stats['bookpie'])}},
            
        }]
    });


      $('#monthbalancechart').highcharts({
            chart: {
                type: 'areaspline'
            },exporting: {
         enabled: false
		},
            title: {
                text: 'Earnings This Month'
            },
           
            xAxis: {
               
               
            },
            yAxis: {
                title: {
                    text: 'CAD $'
                }
            },
           
           
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.24
                }
            },
            series: [{
               showInLegend: false, 
                data: {{json_encode($stats['balance'])}}
            }]
        });

       $('#totbalancechart').highcharts({
            chart: {
                type: 'areaspline'
            },exporting: {
         enabled: false
		},
            title: {
                text: 'All Time Earning'
            },
           
            xAxis: {
               
               
            },
            yAxis: [{
                title: {
                    text: 'CAD'
                }
            }

            ],
           
           
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.24
                }
            },
             series: [{
               showInLegend: false, 
               type:'areaspline',
                data: {{json_encode($stats['totbalance'])}}
            },
            {
               showInLegend: false,
               type: 'column',
                data: {{json_encode($stats['totunits'])}}
            }]
          
        });

              $('#netmajesticschart').highcharts({
            chart: {
                type: 'areaspline'
            },exporting: {
         enabled: false
		},
            title: {
                text: 'NET Majestics / Month'
            },
           
            xAxis: {
               
               
            },
            yAxis: [{
                title: {
                    text: 'Units'
                }
            }

            ],
           
           
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.44
                }
            },
             series: [{
               showInLegend: false, 
               type:'spline',
                data: {{json_encode($stats['netmajestics'])}}
            },
            {
               showInLegend: false,
               type: 'column',
                data: {{json_encode($stats['netmajchart'])}}
            }]
        });

              $('#netdefenderschart').highcharts({
            chart: {
                type: 'areaspline'
            },exporting: {
         enabled: false
		},
            title: {
                text: 'NET Defenders / Month'           },

            xAxis: {
               
               
            },
             yAxis: [{
                title: {
                    text: 'Units'
                }
            }

            ],
           
           
           
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.44
                }
            },
            series: [{
               showInLegend: false, 
               type:'spline',
                data: {{json_encode($stats['netdefenders'])}}
            },
            {
               showInLegend: false,
               type: 'column',
                data: {{json_encode($stats['netdefchart'])}}
            }]
        });

                 $('#grossmajesticschart').highcharts({
            chart: {
                type: 'areaspline'
            },exporting: {
         enabled: false
		},
            title: {
                text: 'GROSS Majestics / Month'
            },
           
            xAxis: {
               
               
            },
            yAxis: [{
                title: {
                    text: 'Units'
                }
            }

            ],
           
           
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.44
                }
            },
             series: [{
               showInLegend: false, 
               type:'spline',
                data: {{json_encode($stats['totmajestics'])}}
            },
            {
               showInLegend: false,
               type: 'column',
                data: {{json_encode($stats['totmajchart'])}}
            }]
        });

              $('#grossdefenderschart').highcharts({
            chart: {
                type: 'areaspline'
            },exporting: {
         enabled: false
		},
            title: {
                text: 'GROSS Defenders / Month'
            },

            xAxis: {
               
               
            },
             yAxis: [{
                title: {
                    text: 'Units'
                }
            }

            ],
           
           
           
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.44
                }
            },
            series: [{
               showInLegend: false, 
               type:'spline',
                data: {{json_encode($stats['totdefenders'])}}
            },
            {
               showInLegend: false,
               type: 'column',
                data: {{json_encode($stats['totdefchart'])}}
            }]
        });

});

	

</script>
@else
<center>
    <br/><br/>
    <h2>Data is Not Shared</h2>
    <p>You are trying to access data, that has otherwise been blocked by this Distributor</p>
    <br/>
</center>
@endif