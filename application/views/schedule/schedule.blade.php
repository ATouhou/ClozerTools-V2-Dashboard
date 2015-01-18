@layout('layouts/main')
@section('content')
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- LEFT SIDE WIDGETS & MENU -->
        <aside> 
            @render('layouts.managernav')
       </aside>
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.css">
<style>
.fc-event-skin {
    background:#1f1f1f!important;
    border:2px solid #000;
}
.fc-event-title {
    color:yellow;
    font-size:13px!important;
}
    .picktime {width:35%;}
    #booker {width:80%;}
    #calendar2 {width:94%;
    font-size:15px;line-height:18px;border:1px solid #6e6e6e;margin-bottom:40px;padding:20px;border-radius:10px;}
</style>
        <div id="page-content" >
             <h1 id="page-header" style="margin-left:10px;margin-top:10px;"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;margin-top:-20px;'>&nbsp;Marketing Schedule</h1>
            <div class="fluid-container" style="margin-top:-30px;">
                  
                    @if(Auth::user()->user_type=="manager")
                    <h5 style="margin-left:10px;">To <b style='color:#000;'>REMOVE</b> a shift, just <b style='color:#000;'>CLICK</b> on it on the calender!!<br/>
                    To <b style='color:#000;'>MOVE</b> a shift simply <b style='color:#000;'>DRAG</b> it to a new day.<br/>
                    To <b style='color:#000;'>COPY</b> a shift, hold <b style='color:#000;'>CTRL or SHIFT and DRAG</b> it to a new day.<br/>
                    </h5>
                    @endif
                    @if(Session::has('hasshift'))
                    <span class="label label-important special">This marketer already has a shift for that date, please delete it, before adding the new shift</span>
                    @endif
                <!-- widget grid -->
                    
                    @if(Auth::user()->user_type=="manager")
                    <div class="row-fluid" style="margin-top:40px;">
                    <div class="span3 well">
                        <h4>ENTER A SHIFT</h4>
                    <form id="schedule" method="post" action="">
                    <span class="date"></span>
                    <label for"booker">Select Booker</label>

                    <select name="booker" id="booker">
                        <option value=""></option>
                        @foreach($bookers as $val)
                        <option value='{{$val->id}}' 
                            @if($val->id==Input::old('booker')) selected="selected" @endif>{{$val->firstname}} {{$val->lastname}}</option>
                        @endforeach
                    </select><br/>
                        Date<br/>
                        <?php $date = Input::old('date');
                        if(empty($date)) $date = date('Y-m-d');?>
                        <div class="input-append date" id="datepicker-js" data-date="{{$date}}" data-date-format="yyyy-mm-dd">
                            <input class="datepicker-input" size="16" id="date" name="date" type="text" value="{{$date}}" placeholder="Select a date" />
                            <span class="add-on"><i class="cus-calendar-2"></i></span>
                        </div>
                    <label for="startime">
                    Start Time : </label>
                    <input tpye="text" class="picktime" id="starttime" name="starttime"><br/><br/>
                    <label for="endtime">Shift End:</label>
                      <input tpye="text" class="picktime" id="endtime" name="endtime"><br/><br/>
                      <button class="btn btn-default">ADD SHIFT</button></form>
                    </div>
                    <div class="span9">
                        <div id='calendar2' class="medShadow" style="background:white;"></div>
                    </div>
                    </div>
                    @else 
                    <div class="row-fluid" >
                        <div id='calendar2' style="background:white;width:90%;"></div>
                    </div>
                    @endif
            </div>    
        <aside class="right">
            @render('layouts.chat')
        </aside>
        </div>
    </div>
</div>
<div class="push"></div>
<script>
$(document).ready(function() {
    $('#agentmenu').addClass('expanded');
    $(".picktime").timePicker({
      startTime: "09:00", 
      endTime: new Date(0, 0, 0, 23, 30, 0), 
      show24Hours: false,
      step: 15});

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        //Detect shift key
        //little technique to detect Shift key
        var shift = function () {
            shifted = false;
            shift.reset = function () {
                this.shifted = false;
            }
        }
        //little technique to detect Shift key
        $(document).keydown(function (e) {
            if (e.keyCode == 16 || e.ctrlKey) {
                shift.shifted = true;
            } else {
                shift.shifted = false;
            }
        }).keyup(function (e) {
            shift.shifted = false;
        });

        var increment=666;
        $('#calendar2').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events:{
                    url:'../agent/getschedule',
            },
            eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
                if(shift.shifted){
                    $.getJSON('../agent/copyshift/'+event.id, {date: dayDelta},function(data){
                        if(data){
                            console.log(data);

                            toastr.success("Shift Copied Successfully!");
                            //CODE HERE TO COPY THE CALENDER JAVASCRIPT OBJECT AND PLACE IN CORRECT DATE
                            $("#calendar2").fullCalendar('renderEvent', data)
                            // Revert the changes in parent even increment. To move it back to original position
                            
                        } else {
                            toastr.error("Failed to Copy Shift, Contact Admin");
                            revertFunc();
                        }
                    });
                    revertFunc();
                } else {
                    $.getJSON('../agent/moveshift/'+event.id, {date: dayDelta},function(data){
                        if(data=="success"){
                            toastr.success("Shift Moved Successfully!");
                        } else {
                            toastr.error("Failed to Move Shift, Contact Admin");
                            revertFunc();
                        }
                    });
                }
                

            },
             @if(Auth::user()->user_type=='manager')
            eventClick: function(calEvent, jsEvent, view){
                $(this).css('border-color', 'red').css('border-width','2px');
               var t = confirm("ARE YOU SURE YOU WANT TO DELETE THIS SHIFT!?");
                if(t){
                    $.getJSON('../agent/delshift/'+calEvent.id, function(data){
                        console.log(data);
                        if(data=="success"){
                            toastr.success("Shift Deleted Successfully!");
                        } else {
                            toastr.error("Failed to Delete Shift, Contact Admin");
                        }
                    });
                    $('#calendar2').fullCalendar('removeEvents', calEvent.id);
                } else {
                $(this).css('border-color', 'black').css('border-width','1px');
                return false;
                } 
            }
            @endif

        });

       
     
    
            
           
   

});
</script>

@endsection