@layout('layouts/main')
@section('content')
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- aside -->  
        <aside> 
            @render('layouts.managernav')
        </aside>
        <!-- aside end -->
        <!-- main content -->
        <div id="page-content">
            <h1 id="page-header">Objection Scripts</h1>   
                <div class="fluid-container">
                        <!-- widget grid -->
                        <section id="widget-grid" class="">
                            <article class="span12" style="margin-bottom:80px;">
                              <button class="btn btn-large btn-primary addScript">ADD A NEW OBJECTION</button>
                              <br><br>
                              <div class="allscripts">
                            @if(!empty($scripts))
							@foreach($scripts as $val)
                            <div class="control-group span5 shadowBOX obj script-{{$val->id}}" style="margin-top:20px;border:1px solid #ccc">
                                <form id="scriptform-{{$val->id}}">
                                <label for="objtitle">Title : </label>
                                <input type="text" name="objtitle" value="{{$val->title}}"/><br/>
                                <input type="hidden" name="scriptid" value="{{$val->id}}" />
                                <label for="objscript">Objection Script</label>
                                <textarea name="objscript" rows=8 >{{$val->script}}</textarea><br><br/>
                                <button class="btn btn-primary btn-mini saveScript" data-id="{{$val->id}}">SAVE</button>
                                <button class="btn btn-mini btn-danger deleteScript" data-id="{{$val->id}}">DELETE</button>
                                </form>
                            </div>
							@endforeach
                            @endif
                        </div>
                        </article>
                        </section>
                </div>      
        </div>
       <!-- end main content -->
       <!-- aside right on high res -->
        <aside class="right">
        @render('layouts.chat')
        <div class="divider"></div>
        <!-- date picker -->
       
        </aside>
    </div>
</div>
<script>
$(document).ready(function(){
$('#scriptmenu').addClass('expanded');

var count=1;
$('.addScript').click(function(){
    count++;
    var html = "<div class='control-group span5 shadowBOX obj newscriptbox-"+count+"' style='margin-top:20px;'>";
    html+="<form id='newscriptform-'"+count+">";
    html+="<label for='objtitle'>Title : </label><input type='text' name='objtitle' />";
    html+="<input type='hidden' name='scriptid' value='0' />";
    html+="<label for='objscript'>Objection Script</label><textarea name='objscript' rows=8 ></textarea><br>";
    html+="<button class='btn btn-primary btn-mini saveScript' data-id=''>SAVE</button>&nbsp;";
    html+="<button class='btn btn-mini btn-danger deleteScript' data-id='newscriptbox-"+count+"'>DELETE</button></div></form>";
    $('.allscripts').prepend(html);
});

$(document).on('click','.deleteScript', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    if(isNaN(id)){
        $('.'+id).hide(200);
    } else {
        $.ajax({type: "POST",
            url: "{{URL::to('scripts/objectiondelete')}}",
            data: {id:id},
                beforeSend: function(){},
                success: function(data) {
                    toastr.success('Script has been deleted!', 'DELETE SUCCESS!');
                    $('.script-'+id).hide(200);
                }
        });
    }
});

$(document).on('click','.saveScript', function(e){
    e.preventDefault(e);
    var form = $(this).parent().serialize();
    var id = $(this).data('id');
    t = $(this);
    $.ajax({
        type: "POST",
        url: "{{URL::to('scripts/objectionsave')}}",
        data: form,
            beforeSend: function(){},
            success: function(data) {
                if(data!=id){
                    t.attr('data-id', data); 
                    t.parent().find('input:hidden:first').val(data);
                    t.parent().find('.deleteScript').attr('data-id',data);
                    t.parent().parent().addClass('script-'+data);
                }
                toastr.success('Script has been updated', 'SAVE SUCCESS!');
            }
    }); 
});


});
</script>
@endsection