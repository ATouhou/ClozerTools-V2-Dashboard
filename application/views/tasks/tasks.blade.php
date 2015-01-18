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
.legend {margin-top:-20px;margin-bottom:20px;float:left;width:100px;margin-right:10px;height:20px;border-radius:4px;text-align:center;font-size:10px;font-weight:bold;border:1px solid #6e6e6e;}
</style>
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
        <div id="page-content">
            <h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;margin-top:-20px;'>&nbsp;Task Manager</h1>
            @if($errors->has())
            @foreach($errors->all() as $v)
            <span class='label label-important special'>{{$v}}</span>&nbsp;&nbsp;
            @endforeach
            <br/><br/>
            @endif
            <div class="fluid-container">
                <div class="row-fluid">
                    <div class="span4 well">
                    <h4>ENTER A NEW TASK</h4>
                        <form id="tasks" method="post" action="{{URL::to('util/addtask')}}">
                            <span class="date"></span>
                            <label for"booker">Select User to Send Task</label>
                            <select name="user" id="user">
                                <option value=""></option>
                                @foreach($users as $val)
                                <option value='{{$val->id}}' 
                                    @if($val->id==Input::old('user')) selected="selected" @endif>
                                    {{$val->firstname}} {{$val->lastname}} -&nbsp;&nbsp; | {{$val->user_type}} |
                                </option>
                                @endforeach
                            </select><br/><br/>
                            <label for="startime">
                            Task Title : </label>
                            <input type="text" class="picktime" id="title" name="title" value="{{Input::old('title')}}"><br/><br/>
                            <label for="endtime">Task Details:</label>
                            <textarea class="picktime" id="details" name="details" value="{{Input::old('details')}}" rows=4></textarea><br/><br/>
                            <button class="btn btn-default"><i class='cus-accept'></i>&nbsp;&nbsp;SEND TASK</button>
                        </form>
                    </div>
                    <div class="span8 well animated fadeInUp">
                        <h4>CURRENT TASKS</h4><br/>
                        <div class="row-fluid">
                            <div class='legend active'>ACTIVE (unseen)</div><div class='legend seen'>ACTIVE (seen)</div><div class='legend done'>TASK COMPLETE</div>
                        </div>
                        @foreach($tasks as $val)
                        <?php if($val->status=="done"){$label='success special';} else if($val->status=="active"){$label='warning special';} else {$label='info special';};?>
                        <div class="task {{$val->status}}" id="task-{{$val->id}}">
                            <div class="span3">
                                <span class='label label-inverse'>{{strtoupper($val->title)}}</span><br/>
                                <span class='label label-{{$label}}' style="margin-top:5px;">  Status :  {{ucfirst($val->status)}}</span><br/>
                                <span class='small' style='margin-top:4px;'>Sent To : {{strtoupper($val->sent_to->firstname)}} {{strtoupper($val->sent_to->lastname)}}</span><br/>
                                <span class='small'>Sent : {{date('M d g:i a',strtotime($val->created_at))}}</span><br/>
                            </div>
                            <div class="span7">
                                {{$val->body}}
                            </div>
                            <div class="span1">
                                <button class='btn btn-danger btn-small deletetask  @if($val->status=='done') animated bounce @endif' data-id='{{$val->id}}'>DELETE</button>
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
$('.deletetask').click(function(){
var id = $(this).data('id');
$.get('../util/deltask/'+id,function(data){
$('#task-'+data).hide(200);
toastr.success('Succesfully removed task!');
});
});
});
</script>
@endsection