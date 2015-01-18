@layout('layouts/main')
@section('content')
<style>
.task {padding:15px;border:1px solid #1f1f1f;
-moz-box-shadow:    inset 0 0 10px #000000;
   -webkit-box-shadow: inset 0 0 10px #000000;
   box-shadow:         inset 0 0 10px #000000;
   float:left;
   width:95%;
   margin-top:10px;}

.done {background:#CCFFCC;}
.active{background:#FFFFCC;}
.seen {background:#CCFFFF;}

.legend {margin-top:0px;margin-bottom:20px;float:left;width:100px;margin-right:10px;height:20px;border-radius:4px;text-align:center;font-size:10px;font-weight:bold;border:1px solid #6e6e6e;}
</style>
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
        <div id="page-content">
            <h1 id="page-header">Your Current Tasks</h1>
            @if($errors->has())
            @foreach($errors->all() as $v)
            <span class='label label-important special'>{{$v}}</span>&nbsp;&nbsp;
            @endforeach
            <br/><br/>
            @endif

            <div class="fluid-container">
                <div class="row-fluid">
                
                    <div class="span12 well">                        
                        <div class="row-fluid">
                            <h5>Color Legend</h5>
                            <div class='legend active'>NEW TASK</div><div class='legend seen'>ACKNOWLEDGED</div><div class='legend done'>TASK COMPLETE</div>
                        </div>
                        @foreach($tasks as $val)
                        <div class="task {{$val->status}}" id="task-{{$val->id}}">
                           
                            <div class="span3">
                                 <span class='label label-inverse'>{{$val->title}}</span></br>
                                 <span class='small'>Status :  {{ucfirst($val->status)}}</span><br/>
                                <span class='small'>{{date('M d',strtotime($val->created_at))}}</span>
                            </div>
                            <div class="span7">
                                {{$val->body}}
                            </div>
                            <div class="span2" style="padding-top:5px;">
                                <button class='btn btn-primary btn-mini updatetask' data-id='{{$val->id}}' data-status='seen'>ACKNOWLEDGE</button><br/>
                                <button class='btn btn-success btn-mini updatetask' style="margin-top:10px;" data-status='done' data-id='{{$val->id}}'>MARK COMPLETE</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>    
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
$('.updatetask').click(function(){
var status = $(this).data('status');
var id = $(this).data('id');
$.getJSON('../../util/updatetask/'+id+'-'+status,function(data){
    console.log(data);
    $('#task-'+data[0]).removeClass('done').removeClass('seen').removeClass('active').addClass(data[1]);
toastr.success('Succesfully updates this task!');
});
});
});
</script>
@endsection