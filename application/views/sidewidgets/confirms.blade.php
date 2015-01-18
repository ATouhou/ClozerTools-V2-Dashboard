<?php 
$thetime= date('H:i:s');

$time1 = strtotime($thetime) + 20*60;
$time2 = strtotime($thetime) + 80*60;
$time1 = date('H:i', $time1);
$time2 = date('H:i',$time2);

$allconfirms = Appointment::where('app_date','=',date('Y-m-d'))->order_by('app_time')->get();
$confirm = Script::where('type','=','confirmation')->get();
$rebook = Script::where('type','=','confrebook')->get();
;?>

@foreach($allconfirms as $val)
@if((($val->status=="APP")&&($val->app_time>=$time1)&&($val->app_time<=$time2))||(($val->status=="BUMP")&&($val->bump_id==Auth::user()->id))||($val->status=="NA"))
<?php 
if($val->status=="APP"){$script = $confirm[0]->attributes;$anim = "fadeInUp";$icon="<i class='cus-accept'></i>";$stat="success";$msg = "CONFIRM APPOINTMENT";$custom="";} elseif($val->status=="NA"){$script = $confirm[0]->attributes;$anim = "fadeInUp";$icon="<i class='cus-telephone'></i>";$stat="warning";$msg="DIDN'T ANSWER, TRY AGAIN";$custom="";} elseif($val->status=="BUMP"){$script = $rebook[0]->attributes; $anim = "bounce";$icon="<i class='cus-arrow-right'></i>";$custom="background:orange;color:#1f1f1f;";$stat="error";$msg = "PLEASE BUMP THIS APPOINTMENT";};?>


<div class="alert adjusted alert-{{$stat}} animated {{$anim}}" style="{{$custom}};padding-left:7px;" >
    <strong> {{$msg}} </strong>&nbsp;&nbsp;|
    Num :  <span class="label label-success special">{{$val->lead->cust_num}}</span>&nbsp;&nbsp;
    Name : <span class="label label-inverse">{{$val->lead->cust_name}}</span>
    @if(!empty($val->lead->spouse_name)) Spouse : <span class="label label-inverse">{{$val->lead->spouse_name}}</span>@endif
     &nbsp;&nbsp;Appointment Time : <span class="label label-info special">{{date('H:i', strtotime($val->app_time))}}</span>
     &nbsp;&nbsp;
     @if($val->bump_notes)
     <strong>Bump Notes :</strong> <span class='label label-info special'>{{$val->bump_notes}}</span>

     @endif
    <button class="btn btn-mini btn-primary clicktoconfirm" data-id="confirm-{{$val->id}}" style="float:right;">CLICK TO CONFIRM</button>
    
    <div class="confirminfo" id="confirm-{{$val->id}}" style="display:none;height:400px;">
        <div class="row-fluid">
        <div class="span5"><br/>
        <span class="label label-success">Customer has been called {{count($val->lead->calls)}} times</span><br/>
        <h5>Address:&nbsp;&nbsp;<span class="label label-inverse">{{$val->lead->address}}</span></h5>
        <div class="span12 shadowBOX" style="font-size:15px;background:white;padding:22px;border-radius:5px;margin-top:10px;">
        Hi there, may I speak with <span class="label label-info">{{strtoupper($val->lead->cust_name)}}</span>?<br>
        Hi <span class="label label-info">{{strtoupper($val->lead->cust_name)}}</span>, this is <span class="label label-info">{{Auth::user()->firstname}}</span> from Advanced Air.<br>
        {{$script['script']}}

        </div>
        </div>

        <div class="span4" style="float:right;">
        <h4>Choose an update Status</h4>
        <form id="updateappointment" method="post" action="{{URL::to('appointment/process')}}">
        <input type="hidden" name="idnum" id="idnum" value="{{$val->id}}" />
       
        <select name="result" id="result" data-id="{{$val->id}}">
            <option value="CONF">CONFIRMED</option>
            <option value="NA">NOT AVAIL.</option>
            <option value="RB-OF">Rebook - Our Fault</option>
            <option value="RB-TF">Rebook - Their Fault</option>
            <option value="CXL">CANCEL</option>
            <option value="NQ">Not Qualified</option>
        </select>
        <div id="time-{{$val->id}}" style="margin-top:15px;display:none">
            <label for="time">Pick Time to Rebook <br/><span class="small">Leave time blank to just mark as a general REBOOK<br/>Add notes if no time is chosen</span></label>
                 <input id="booktimepicker" class="booktimepicker" name="booktimepicker" type="text" placeholder="Select Time..." style="width:20%;" />
                     <label for="time">Pick New Appt. Date</label>
                        <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
                            <input class="datepicker-input" size="16" id="appdate" name="appdate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
                            <span class="add-on"><i class="cus-calendar-2"></i></span>
                            </div>
        </div>

        <label for="notes">Customer Notes</label>
        <textarea name="notes" id="confnotes" rows=3>{{$val->lead->notes}}</textarea>
        <br>
        <button class="btn btn-large btn default">UPDATE APPOINTMENT</button>
        </form>
        </div>
    </div>
    </div>
</div>
@endif
@endforeach
<script>
$(document).ready(function(){

    $('#result').change(function(){
        var r = $(this).val();
        var id = $(this).data('id');
        if((r=="RB-OF")||(r=="RB-TF")){
            $('#time-'+id).show(300);
        } else {$('#time-'+id).hide();}
    });

$(".booktimepicker").timePicker({
  startTime: "10:00", // Using string. Can take string or Date object.
  endTime: new Date(0, 0, 0, 23, 30, 0), // Using Date object here.
  show24Hours: false,
  step: 15});
});
</script>