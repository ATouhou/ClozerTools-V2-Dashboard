@layout('layouts/main')
@section('content')
<style>
.edit{cursor:pointer;}
.edit:hover{
    background:blue;
}
.cityRow {}
.apptimetable td {font-weight:bolder; text-align:center;}
.apptimetable td.nocenter {text-align:left!important; font-weight:normal;}
.apptimetable th {background:#ddd;color:#000!important;font-size:14px!important;}
</style>
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- aside -->  
        <aside> 
            @render('layouts.managernav')
        </aside>
        <!-- aside end -->
                
        <!-- main content -->
        <div id="page-content">
            <h1 id="page-header">Set Needed Appointment Times </h1>   
                <div class="fluid-container">
                        <div class="row-fluid" style='margin-bottom:20px;'>
                            <h4>Select a City</h4>
                            @foreach($cities as $c)
                            <button class='btn btn-mini neededCity' data-name='{{str_replace(array(",","."," "),"-",$c->cityname)}}' style='margin-top:6px;'>{{$c->cityname}}</button>
                            @endforeach
                            <h4>Select an Area</h4>
                            @foreach($areas as $a)
                            <button class='btn btn-mini neededCity' data-name='{{$a->id}}' style='margin-top:6px;'>{{$a->cityname}}</button>
                            @endforeach
                        </div>

                        <section id="widget-grid" class="" style="margin-top:20px;">
                            <div class="row-fluid" id="appboard">
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            <h2>DEMOS ALREADY BOOKED</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <table class="table table-striped table-bordered responsive apptimetable">
                                                    <thead>
                                                        <tr align="center">
                                                            <th style="width:13%;">City / Area Name</th>                                                  
                                                            <th style="border-left:4px solid #000;" colspan=5 >{{date('l - M d')}}</th>
                                                            <th style="border-left:4px solid #000;" colspan=5 >{{date('l - M d',strtotime('+1 Day'))}}</th>
                                                            <th style="border-left:4px solid #000;" colspan=5 >{{date('l - M d',strtotime('+2 Day'))}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($needed as $key=>$val)
                                                        <tr class="cityRow animated fadeInUp cityrow-{{$key}}">    
                                                            <td class="span3 " >{{$val['day1']['needed']['name']}}</td>
                                                        
                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/>@if(isset($val['day1']['onboard'])) 
                                                        @if($val['day1']['onboard'][0]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day1']['onboard'][0]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[1]['title']}}<br/>@if(isset($val['day1']['onboard'])) 
                                                        @if($val['day1']['onboard'][1]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day1']['onboard'][1]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[2]['title']}}<br/>@if(isset($val['day1']['onboard'])) 
                                                        @if($val['day1']['onboard'][2]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day1']['onboard'][2]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[3]['title']}}<br/>@if(isset($val['day1']['onboard'])) 
                                                        @if($val['day1']['onboard'][3]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day1']['onboard'][3]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[4]['title']}}<br/>@if(isset($val['day1']['onboard'])) 
                                                        @if($val['day1']['onboard'][4]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day1']['onboard'][4]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/>@if(isset($val['day2']['onboard'])) 
                                                        @if($val['day2']['onboard'][0]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day2']['onboard'][0]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[1]['title']}}<br/>@if(isset($val['day2']['onboard'])) 
                                                        @if($val['day2']['onboard'][1]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day2']['onboard'][1]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>


                                                        <td>
                                                        {{$slots[2]['title']}}<br/>@if(isset($val['day2']['onboard'])) 
                                                        @if($val['day2']['onboard'][2]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day2']['onboard'][2]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[3]['title']}}<br/>@if(isset($val['day2']['onboard'])) 
                                                        @if($val['day2']['onboard'][3]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day2']['onboard'][3]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>


                                                        <td>
                                                        {{$slots[4]['title']}}<br/>@if(isset($val['day2']['onboard'])) 
                                                        @if($val['day2']['onboard'][4]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day2']['onboard'][4]}}|{{$val['day2']['needed'][4]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        

                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/>@if(isset($val['day3']['onboard'])) 
                                                        @if($val['day3']['onboard'][0]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day3']['onboard'][0]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[1]['title']}}<br/>@if(isset($val['day3']['onboard'])) 
                                                        @if($val['day3']['onboard'][1]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day3']['onboard'][1]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>
                                                        <td>
                                                        {{$slots[2]['title']}}<br/>@if(isset($val['day3']['onboard'])) 
                                                        @if($val['day3']['onboard'][2]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day3']['onboard'][2]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[3]['title']}}<br/>@if(isset($val['day3']['onboard'])) 
                                                        @if($val['day3']['onboard'][3]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day3']['onboard'][3]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>
                                                        <td>
                                                        {{$slots[4]['title']}}<br/>@if(isset($val['day3']['onboard'])) 
                                                        @if($val['day3']['onboard'][4]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day3']['onboard'][4]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>
                                                      
                                                    </tr>
                                                    @endforeach
                                                    @if(!empty($neededarea))
                                                    @foreach($neededarea as $key=>$val)
                                                        <tr class="cityRow animated fadeInUp cityrow-{{$key}}">    
                                                            <td class="span3 " >{{$val['day1']['needed']['name']}}</td>
                                                        
                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/>@if(isset($val['day1']['onboard'])) 
                                                        @if($val['day1']['onboard'][0]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day1']['onboard'][0]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[1]['title']}}<br/>@if(isset($val['day1']['onboard'])) 
                                                        @if($val['day1']['onboard'][1]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day1']['onboard'][1]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[2]['title']}}<br/>@if(isset($val['day1']['onboard'])) 
                                                        @if($val['day1']['onboard'][2]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day1']['onboard'][2]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[3]['title']}}<br/>@if(isset($val['day1']['onboard'])) 
                                                        @if($val['day1']['onboard'][3]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day1']['onboard'][3]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[4]['title']}}<br/>@if(isset($val['day1']['onboard'])) 
                                                        @if($val['day1']['onboard'][4]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day1']['onboard'][4]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/>@if(isset($val['day2']['onboard'])) 
                                                        @if($val['day2']['onboard'][0]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day2']['onboard'][0]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[1]['title']}}<br/>@if(isset($val['day2']['onboard'])) 
                                                        @if($val['day2']['onboard'][1]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day2']['onboard'][1]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>


                                                        <td>
                                                        {{$slots[2]['title']}}<br/>@if(isset($val['day2']['onboard'])) 
                                                        @if($val['day2']['onboard'][2]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day2']['onboard'][2]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[3]['title']}}<br/>@if(isset($val['day2']['onboard'])) 
                                                        @if($val['day2']['onboard'][3]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day2']['onboard'][3]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>


                                                        <td>
                                                        {{$slots[4]['title']}}<br/>@if(isset($val['day2']['onboard'])) 
                                                        @if($val['day2']['onboard'][4]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day2']['onboard'][4]}}|{{$val['day2']['needed'][4]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        

                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/>@if(isset($val['day3']['onboard'])) 
                                                        @if($val['day3']['onboard'][0]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day3']['onboard'][0]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[1]['title']}}<br/>@if(isset($val['day3']['onboard'])) 
                                                        @if($val['day3']['onboard'][1]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day3']['onboard'][1]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>
                                                        <td>
                                                        {{$slots[2]['title']}}<br/>@if(isset($val['day3']['onboard'])) 
                                                        @if($val['day3']['onboard'][2]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day3']['onboard'][2]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>

                                                        <td>
                                                        {{$slots[3]['title']}}<br/>@if(isset($val['day3']['onboard'])) 
                                                        @if($val['day3']['onboard'][3]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day3']['onboard'][3]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>
                                                        <td>
                                                        {{$slots[4]['title']}}<br/>@if(isset($val['day3']['onboard'])) 
                                                        @if($val['day3']['onboard'][4]!=0)
                                                        <span class='label totalStat label-success special'> {{$val['day3']['onboard'][4]}}</span> 
                                                        @else <span class='label totalStat'>0</span>@endif @else <span class='label totalStat'>0</span> @endif</td>
                                                      
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                    </div>
                                    <!-- end widget -->
                                </article>
                        </div>
                       	<div class="row-fluid" id="needed">
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            <h2>APPOINTMENTS NEEDED FOR EACH SLOT  &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;  
                                                Just click a number to edit it<br/>
                                                Choose the number of demos you usually need each day </h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <table class="table table-striped table-bordered responsive apptimetable"  >
                                                    <thead>
                                                           <tr align="center">
                                                            <th style="width:13%;">City / Area Name</th>                                                  
                                                            <th style="border-left:4px solid #000;" colspan=5 >{{date('l - M d')}}</th>
                                                            <th style="border-left:4px solid #000;" colspan=5 >{{date('l - M d',strtotime('+1 Day'))}}</th>
                                                            <th style="border-left:4px solid #000;" colspan=5 >{{date('l - M d',strtotime('+2 Day'))}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($cities as $val)
                                                    
                                                    <?php $cityName = str_replace(array(",","."," "),"-",$val->cityname);?>
                                                    <tr class="cityRow animated fadeInUp cityrow-{{$cityName}}" >
                                                     	<td class="span3">{{$val->cityname}}
                                                       </td>
													 	
                                                        <?php if(isset($needed[$cityName]['day1']['onboard'])){
                                                            $id = $needed[$cityName]['day1']['onboard'][0];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/> <span class='edit label totalStat label-inverse' id="{{$id}}|today_slot1|{{$val->id}}">{{$val->today_slot1-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day1']['onboard'])){
                                                            $id = $needed[$cityName]['day1']['onboard'][1];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[1]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|today_slot2|{{$val->id}}">{{$val->today_slot2-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day1']['onboard'])){
                                                            $id = $needed[$cityName]['day1']['onboard'][2];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[2]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|today_slot3|{{$val->id}}">{{$val->today_slot3-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day1']['onboard'])){
                                                            $id = $needed[$cityName]['day1']['onboard'][3];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[3]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|today_slot4|{{$val->id}}">{{$val->today_slot4-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day1']['onboard'])){
                                                            $id = $needed[$cityName]['day1']['onboard'][4];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[4]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|today_slot5|{{$val->id}}">{{$val->today_slot5-$id}}</span></td>
                                                        
                                                       
                                                        <?php if(isset($needed[$cityName]['day2']['onboard'])){
                                                            $id = $needed[$cityName]['day2']['onboard'][0];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/> <span class='edit label totalStat label-inverse' id="{{$id}}|tomorrow_slot1|{{$val->id}}">{{$val->tomorrow_slot1-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day2']['onboard'])){
                                                            $id = $needed[$cityName]['day2']['onboard'][1];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[1]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|tomorrow_slot2|{{$val->id}}">{{$val->tomorrow_slot2-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day2']['onboard'])){
                                                            $id = $needed[$cityName]['day2']['onboard'][2];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[2]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|tomorrow_slot3|{{$val->id}}">{{$val->tomorrow_slot3-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day2']['onboard'])){
                                                            $id = $needed[$cityName]['day2']['onboard'][3];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[3]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|tomorrow_slot4|{{$val->id}}">{{$val->tomorrow_slot4-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day2']['onboard'])){
                                                            $id = $needed[$cityName]['day2']['onboard'][4];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[4]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|tomorrow_slot5|{{$val->id}}">{{$val->tomorrow_slot5-$id}}</span></td>
                                                       
                                                       
                                                       <?php if(isset($needed[$cityName]['day3']['onboard'])){
                                                            $id = $needed[$cityName]['day3']['onboard'][0];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/> <span class='edit label totalStat label-inverse' id="{{$id}}|twoday_slot1|{{$val->id}}">{{$val->twoday_slot1-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day3']['onboard'])){
                                                            $id = $needed[$cityName]['day3']['onboard'][1];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[1]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|twoday_slot2|{{$val->id}}">{{$val->twoday_slot2-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day3']['onboard'])){
                                                            $id = $needed[$cityName]['day3']['onboard'][2];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[2]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|twoday_slot3|{{$val->id}}">{{$val->twoday_slot3-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day3']['onboard'])){
                                                            $id = $needed[$cityName]['day3']['onboard'][3];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[3]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|twoday_slot4|{{$val->id}}">{{$val->twoday_slot4-$id}}</span></td>
                                                        <?php if(isset($needed[$cityName]['day3']['onboard'])){
                                                            $id = $needed[$cityName]['day3']['onboard'][4];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[4]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|twoday_slot5|{{$val->id}}">{{$val->twoday_slot5-$id}}</span></td>
                                                       
                                                   	</tr>
                                                    
                                                    @endforeach
                                                    @if(!empty($areas))
                                                     @foreach($areas as $val)
                                                    
                                                    <?php $cityName = $val->id;?>
                                                    <tr class="cityRow animated fadeInUp cityrow-{{$cityName}}" >
                                                        <td class="span3">{{$val->cityname}}
                                                       </td>
                                                        
                                                        <?php if(isset($neededarea[$cityName]['day1']['onboard'])){
                                                            $id = $neededarea[$cityName]['day1']['onboard'][0];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/> <span class='edit label totalStat label-inverse' id="{{$id}}|today_slot1|{{$val->id}}">{{$val->today_slot1-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day1']['onboard'])){
                                                            $id = $neededarea[$cityName]['day1']['onboard'][1];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[1]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|today_slot2|{{$val->id}}">{{$val->today_slot2-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day1']['onboard'])){
                                                            $id = $neededarea[$cityName]['day1']['onboard'][2];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[2]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|today_slot3|{{$val->id}}">{{$val->today_slot3-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day1']['onboard'])){
                                                            $id = $neededarea[$cityName]['day1']['onboard'][3];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[3]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|today_slot4|{{$val->id}}">{{$val->today_slot4-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day1']['onboard'])){
                                                            $id = $neededarea[$cityName]['day1']['onboard'][4];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[4]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|today_slot5|{{$val->id}}">{{$val->today_slot5-$id}}</span></td>
                                                        
                                                       
                                                        <?php if(isset($neededarea[$cityName]['day2']['onboard'])){
                                                            $id = $neededarea[$cityName]['day2']['onboard'][0];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/> <span class='edit label totalStat label-inverse' id="{{$id}}|tomorrow_slot1|{{$val->id}}">{{$val->tomorrow_slot1-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day2']['onboard'])){
                                                            $id = $neededarea[$cityName]['day2']['onboard'][1];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[1]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|tomorrow_slot2|{{$val->id}}">{{$val->tomorrow_slot2-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day2']['onboard'])){
                                                            $id = $neededarea[$cityName]['day2']['onboard'][2];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[2]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|tomorrow_slot3|{{$val->id}}">{{$val->tomorrow_slot3-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day2']['onboard'])){
                                                            $id = $neededarea[$cityName]['day2']['onboard'][3];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[3]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|tomorrow_slot4|{{$val->id}}">{{$val->tomorrow_slot4-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day2']['onboard'])){
                                                            $id = $neededarea[$cityName]['day2']['onboard'][4];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[4]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|tomorrow_slot5|{{$val->id}}">{{$val->tomorrow_slot5-$id}}</span></td>
                                                       
                                                       
                                                       <?php if(isset($neededarea[$cityName]['day3']['onboard'])){
                                                            $id = $neededarea[$cityName]['day3']['onboard'][0];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td style="border-left:4px solid #000;">
                                                        {{$slots[0]['title']}}<br/> <span class='edit label totalStat label-inverse' id="{{$id}}|twoday_slot1|{{$val->id}}">{{$val->twoday_slot1-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day3']['onboard'])){
                                                            $id = $neededarea[$cityName]['day3']['onboard'][1];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[1]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|twoday_slot2|{{$val->id}}">{{$val->twoday_slot2-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day3']['onboard'])){
                                                            $id = $neededarea[$cityName]['day3']['onboard'][2];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[2]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|twoday_slot3|{{$val->id}}">{{$val->twoday_slot3-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day3']['onboard'])){
                                                            $id = $neededarea[$cityName]['day3']['onboard'][3];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[3]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|twoday_slot4|{{$val->id}}">{{$val->twoday_slot4-$id}}</span></td>
                                                        <?php if(isset($neededarea[$cityName]['day3']['onboard'])){
                                                            $id = $neededarea[$cityName]['day3']['onboard'][4];
                                                        } else {$id=0;}
                                                        ?>
                                                        <td>
                                                        {{$slots[4]['title']}}<br/><span class='edit label totalStat label-inverse' id="{{$id}}|twoday_slot5|{{$val->id}}">{{$val->twoday_slot5-$id}}</span></td>
                                                       
                                                    </tr>
                                                    
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                    </div>
                                    <!-- end widget -->
                                
                                </article>


                        </div>

                       

						        
                        </section>
                </div>      
        </div>
        <aside class="right">
        @render('layouts.chat')
        
        </aside>
    </div>
</div>
<script src="{{URL::to_asset('js/editable.js')}}"></script>

<script>
$(document).ready(function(){
$('#appointment').addClass('expanded');


$('.neededCity').click(function(){
    $('.neededCity').removeClass('btn-inverse');
    $(this).addClass('btn-inverse');
    var city = $(this).data('name');
    $('.cityRow').hide();
    $('.cityrow-'+city).show();
    localStorage.setItem("cityNeeded",city);
});


if(localStorage){
        if(localStorage.getItem("cityNeeded")){
           cit = localStorage.getItem("cityNeeded");
           $('.cityRow').hide();
           $('.cityrow-'+cit).show();
           $('.neededCity').each(function(i,val){
                var n = $(this).data('name');
                if(n==cit){
                    $(this).addClass('btn-inverse');
                }
           });
        } 
    }



$('.edit').editable('{{URL::to("cities/timeslot")}}',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK',
         placeholder: '.',
         width:'50',
         height:'30',
        /* callback: function(){
            location.reload();
         }*/
});
});
</script>
@endsection