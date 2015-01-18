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
.archive {background:#eee;}
.legend {margin-top:-20px;margin-bottom:20px;float:left;width:100px;margin-right:10px;height:20px;border-radius:4px;text-align:center;font-size:10px;font-weight:bold;border:1px solid #6e6e6e;}
</style>
<div id="main" role="main" class="container-fluid">
  
    <div class="modal full-screen hide fade" id="bugreply_modal" style="">
        <div class="modal-header">
            <h4>SUBMIT REPLY TO THIS {{strtoupper($type)}}</h4>
                
        </div>
        <div class="modal-body">
            <form id="reply" action="{{URL::to('util/bugsubmit')}}" method="post">
                <input type="hidden" id="thread_id" name="thread_id" value=""/>
                <input type="hidden" id="thesummary" name="summary" value=""/>
                <input type="hidden" id="thetype" name="type" value="answer"/>
                <textarea class='span5' name="description" id="replymessage" rows=8></textarea>
        </div>
        <div class="modal-footer">
            <button class='btn btn-primary'>SUBMIT</button>
            </form>
            <button class='btn btn-danger' data-dismiss="modal">CLOSE</button>
        </div>
    </div>


    <div class="contained">
        <aside> 
            @render('layouts.managernav')
        </aside>
        <div id="page-content">
            <h1 id="page-header"> @if($type=="bug")
                        Report a Bug
                        @elseif($type=="suggestion")
                        Suggestion Box
                        @endif</h1>
            @if($errors->has())
            @foreach($errors->all() as $v)
            <span class='label label-important special'>{{$v}}</span>&nbsp;&nbsp;
            @endforeach
            <br/><br/>
            @endif
            <div class="fluid-container">
                <div class="row-fluid">
                    <div class="span4 well">
                    <h4>
                        @if($type=="bug")
                        REPORT A NEW BUG
                        @elseif($type=="suggestion")
                        SUBMIT A SUGGESTION
                        @endif
                    </h4>
                        <form id="bugs" method="post" action="{{URL::to('util/bugsubmit')}}">
                            <span class="date"></span>
                            <input type="hidden" name="type" id="type" value="{{$type}}">
                            <label for="summary">
                              {{ucfirst($type)}} Summary : </label>
                            <input type="text" id="summary" name="summary" value="{{Input::old('summary')}}"><br/><br/>
                            <label for="priority">Select Priority</label>
                            <select name="priority" id="priority">
                                <option value="regular">Regular</option>
                                <option value="urgent">Urgent</option>
                                <option value="hotfix">Hotfix</option>
                                <option value="backburner">Back-Burner</option>
                            </select><br/><br/>
                            <label for="description">Detailed description of {{ucfirst($type)}}:</label>
                            
                            @if($type=="bug")
                            <span class='small'>Be as descriptive as possible, dont just write Unhandled Exception, or Error.  Write what the error says, what page you were on, and if there was a sequence of events you remember.</span><br/><br/>
                            @endif
                            <textarea id="description" name="description" value="{{Input::old('details')}}" style='width:80%;' rows=12></textarea><br/><br/>
                            @if($type=="bug")
                            <button class="btn btn-default"><i class='cus-bug'></i>&nbsp;&nbsp;REPORT BUG</button>
                            @elseif($type=="suggestion")
                            <button class="btn btn-default"><i class='cus-inbox'></i>&nbsp;&nbsp;SUBMIT SUGGESTION</button>
                            @endif
                            
                        </form>
                    </div>
                    <div class="span8 well animated fadeInUp">
                        <h4>CURRENT {{strtoupper($type)}} TICKETS <button class='btn btn-default viewArchive' style='float:right;'>VIEW OLD / ARCHIVED</button><button class='btn btn-success viewActive' style='float:right;margin-right:10px;color:#000'>VIEW ACTIVE</button></h4><br/>
                        <div class="row-fluid">
                            <div class='legend active'>UNSEEN</div><div class='legend seen'>WORKING ON IT</div><div class='legend done'>COMPLETED</div>
                        </div>
                        @foreach($bugs as $val)
                        <?php if($val->status=="completed"){$label='success special';$status='done';} else if($val->status=="seen"){$label='warning special';$status='seen';} else {$label='info special';$status='active';};
                        if($val->priority=="urgent"){$priority='important special';} else if($val->priority=="regular"){$priority='info special';} else {$priority='inverse special';};?>
                        <div class="task {{$val->status}} {{$status}}" data-status='{{$val->status}}' id="task-{{$val->id}}">
                            <div class="span3">
                                <span class='label label-inverse'>{{strtoupper($val->summary)}}</span><br/>
                                <span class='label label-{{$label}}' style="margin-top:5px;">  Status :  {{ucfirst($val->status)}}</span><br/>

                                <span class='small' style='margin-top:4px;'>Sent By: {{strtoupper($val->user->firstname)}} {{strtoupper($val->user->lastname)}}</span><br/>
                                <span class='small'>Sent On : {{date('M d g:i a',strtotime($val->created_at))}}</span><br/>
                                PRIORITY :  <span class='label label-{{$priority}}' style="margin-top:5px;">  {{ucfirst($val->priority)}}</span><br/>
                            </div>
                            <style>
                            .response {display:none;float:left;background:white;width:90%;min-height:40px;border:1px solid #ddd;margin-top:5px;padding:10px;}
                            .responsereply {float:right;width:80%;min-height:30px;border:1px solid #ddd;margin-top:5px;padding:10px;}
                            .responsebody {border-bottom:1px solid #1f1f1f;padding-bottom:10px;margin-bottom:5px;}
                            </style>
                            <div class="span8" style="padding:20px;">
                                {{$val->description}}<br/><br/>
                                 @if(Auth::user()->id==58)
                                 <button class='btn btn-warning btn-mini mark' style='color:#000;' data-id='{{$val->id}}-seen'>SEEN</button>
                                <button class='btn btn-success btn-mini mark' style='color:#000;' data-id='{{$val->id}}-completed'>COMPLETE</button>
                                @endif
                                 @if($val->thread)
                                <button class="btn btn-success btn-mini viewresponse" data-id="{{$val->id}}">VIEW RESPONSES</button>
                                @endif
                                <button class='btn btn-primary btn-mini reply  @if($val->status=='completed') animated bounce @endif' data-summary="{{$val->summary}}" data-id='{{$val->id}}'>REPLY</button>
                                @if(($val->user_id==Auth::user()->id)||(Auth::user()->id==58))
                                <button class='btn btn-danger btn-mini deletebug  @if($val->status=='completed') animated bounce @endif' data-type='delete' data-id='{{$val->id}}'>DELETE</button>
                                <button class='btn btn-default btn-mini deletebug  @if($val->status=='completed') animated bounce @endif' data-type='archive' data-id='{{$val->id}}'>ARCHIVE</button>
                                @endif
                                
                               
                            </div>
                            @if($val->thread)
                            @foreach($val->thread as $val2)
                                <div class='response resp-{{$val2->thread_id}}' id="task-{{$val2->id}}">
                                    <div class='responsebody'>
                                        {{$val2->description}}
                                    </div>
                                    <span class='label label-info'>Reply From : {{$val2->user->firstname}} {{$val2->user->lastname}}</span> <span class='label label-inverse'>Sent on : {{date('M-d h:i a',strtotime($val2->created_at))}}</span> 
                                    <button class='btn btn-primary btn-mini reply  @if($val2->status=='completed') animated bounce @endif' data-summary="{{$val->summary}}" data-id='{{$val->id}}'>REPLY</button>
                                    @if(($val2->user_id==Auth::user()->id)||(Auth::user()->id==58))
                                <button class='btn btn-danger btn-mini deletebug  @if($val->status=='completed') animated bounce @endif' data-id='{{$val2->id}}'>DELETE</button>
                                @endif

                                    
                                </div>
                               
                            @endforeach
                            @endif
                           
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
$('#bugmenu').addClass('expanded');

$('.viewActive').click(function(){
    $('.task').show(); 
    $('.archive').hide();
});

$('.viewArchive').click(function(){
    $('.task').hide();
    $('.archive').show();
});

$('.deletebug').click(function(){
    var id = $(this).data('id');
    var type = $(this).data('type');
    var t = confirm('Are you sure you want to '+type+' this item??');
    if(t){
    $.get('../../util/delbug/'+id,{type:type},function(data){
    $('#task-'+data).hide(200);
    toastr.success('Succesfully removed this Bug/Suggestion!');
    });}
});

$('.mark').click(function(){
    var id = $(this).data('id');

    $.get('../../util/editbug/'+id,function(data){
        location.reload();
    });
});

$('.viewresponse').click(function(){
    var id = $(this).data('id');
    $('.resp-'+id).toggle(200);
});

$('.reply').click(function(){
    var id = $(this).data('id');
    var summary = $(this).data('summary');
    $('#thread_id').val(id);
    $('#thesummary').val(summary);
    $('#bugreply_modal').modal({backdrop: 'static'});
});

$('.task').each(function(i,val){
    var stat = $(this).data('status');
    if(stat=="archive"){
     $(this).hide(); 
    } else {
    
    }
   
});

});
</script>
@endsection