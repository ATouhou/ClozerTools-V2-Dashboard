@layout('layouts/main')
@section('content')
<style>
.removeItem {
    margin-bottom:5px;
}
</style>
<div class="modal hide fade" id="addcrew_modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3> Create a New Road Crew </h3>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ URL::to('cities/createcrew') }}" id="createcrew_form" >
            <label>Crew Name</label>
           <input type="text" name="crew_name" id="crew_name" />
           <br/>
           <label>Select a Crew Manager</label>
           <select name="crew_manager">
            <option value=""></option>
            @foreach($dealer as $val)
            <option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}</option>
            @endforeach
           </select>
          <br>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <button type="button" onclick="$('#createcrew_form').submit();" class="btn btn-primary">Add Crew</a>
    </div>
</div>

<div class="modal hide fade" id="addusers_modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3> Add Dealers to Crew </h3>
    </div>
    <div class="modal-body">
        <form method="POST" action="{{ URL::to('cities/adddealertocrew') }}" id="adddealer_form" >

             
            <input type="hidden" name="crew_id" id="crew_id" value="" />
            <div class="row-fluid">
            <div class="span6">
            <label>Select Crew Manager</label>
           <select name="crewmanager" id="crewmanager">
            <option value=""></option>
            @foreach($dealer as $val)
            <option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}</option>
            @endforeach
           </select>
       </div>
<div class="span5">
             <label>Select Van Manager</label>
           <select name="vanmanager" id="vanmanager">
            <option value=""></option>
            @foreach($dealer as $val)
            <option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}</option>
            @endforeach
           </select>
       </div>
   </div>
  
            <label>Select Dealers</label>
            @for($i=0;$i<6;$i++)
           <select name="crew_dealer[]" id="crew_dealer[]">
            <option value=""></option>
            @foreach($dealer as $val)
            <option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}</option>
            @endforeach
           </select>
           @endfor

             <label>Select Cities Covered By Crew</label>
            @for($i=0;$i<6;$i++)
           <select name="crew_cities[]" id="crew_cities[]">
            <option value=""></option>
            @foreach($cities as $val)
            <option value="{{$val->id}}">{{$val->cityname}}</option>
            @endforeach
           </select>
           @endfor

          <br>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <button type="button "  class="submitUsers btn btn-primary">Add Crew Members</a>
    </div>
</div>


<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- aside -->  
        <aside> 
            @render('layouts.managernav')
        </aside>
        <!-- aside end -->
                
        <!-- main content -->
        <div id="page-content">
            <h1 id="page-header">Crew Management<button class='btn btn-primary pull-right' onclick="$('#addcrew_modal').modal({backdrop: 'static'});" style="margin-top:10px;">CREATE A CREW</button></h1>   
                <div class="fluid-container">
                        <!-- widget grid -->
                       
                        <section id="widget-grid" class="" style="margin-bottom:400px;">
                        	<div class="row-fluid" id="quadrants">
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget medShadow black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            <h2>CREW MANAGEMENT</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <table class="table table-striped table-bordered responsive"  >
                                                    <thead>
                                                        <tr align="center">
                                                                
    														<th>Crew Name</th>
                                                            <th style="width:30%;">Cities Covered By Crew</th>                     	                                    
															<th style="width:50%;">Dealers in Crew</th>
															<th>Options</th>
														</tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($crews as $val)
                                                    <tr id="crewrow-{{$val->id}}">
                                                     	<td class="span3"><span class="edit label label-inverse tooltwo" style="font-size:14px;" id="crew_name|{{$val->id}}" title="Click to edit Crew Name">{{$val->crew_name}}</span><br/>
                                                        </td>
                                                        <td  class="crewcities-{{$val->id}}">
                                                            @foreach($val->cities() as $b)
                                                            <button class='btn btn-inverse btn-mini removeItem' data-id="{{$b->id}}">{{$b->city->cityname}}</button>&nbsp;
                                                            @endforeach
                                                        </td>
													 	<td class="crewdealers-{{$val->id}}">
                                                              @foreach($val->members() as $m)
                                                              <?php if($m->type=="crewmanager"){$lab = "success";$t="is Crew Manager of this Road Crew";} 
                                                              else if($m->type=="vanmanager"){$lab = "primary";$t="is a Van Manager for this Road Crew";} 
                                                              else {$lab="inverse ";$t="is a Dealer in this Road Crew";};?>

                                                            <button class='btn btn-{{$lab}} btn-mini removeItem tooltwo'  data-id="{{$m->id}}" data-user="{{$m->user_id}}" title="{{$m->member->firstname}} {{$t}}">{{$m->member->firstname}} {{substr($m->member->lastname,0,1)}}</button>&nbsp;
                                                            @endforeach
                                                           
                                                            <div class='quadrants quad-{{$val->id}}' style='display:none'>
     													    @foreach($val->relationships as $q)
															    @foreach($q as $v)
																<button style="margin-top:6px;" class='btn btn-inverse btn-mini deleteQuadrant tooltwo' title="Click to remove this quadrant" id="quadblock-{{$v->attributes['id']}}" data-id="{{$v->attributes['id']}}">{{$v->attributes['exchange']}}</button>  &nbsp;
															    @endforeach															
														    @endforeach
                                                            </div>
														</td>
														<td class="span2">
                                                        <button class="btn btn-primary btn-mini addUsers" data-crew="{{$val->id}}" >ADD DEALERS&nbsp;</button>
														 <button style="margin-top:4px;" class="btn btn-danger btn-mini deleteCrew"  data-crew="{{$val->id}}">DELETE CREW&nbsp;</button></td>
                                                   	</tr>
                                                    @endforeach
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
                        <!-- end widget grid -->
                </div>      
        </div>
        <!-- end main content -->
            
        <!-- aside right on high res -->
        <aside class="right">
        @render('layouts.chat')
        <div class="divider"></div>
        </aside>
    </div>
</div>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
$('#citymenu').addClass('expanded');


$(document).on('click','.removeItem',function(){
    var id = $(this).data('id');
    var t = $(this);
    $.getJSON("{{URL::to('crew/removecrewitem/')}}"+id,function(data){
        t.hide();
        toastr.success("Succesfully removed from Crew");
    });
});

$('.edit').editable('{{URL::to("crew/crewedit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit Crew Name',
         submit  : 'OK',
         placeholder: '....',
         width     : '100',
         height    : '25',
         callback: function(value,settings){
            console.log(value);
         }
});


$('.addUsers').click(function(){
var crew = $(this).data('crew');
$('#crew_id').val(crew);
$('#adddealer_form')[0].reset();
$('#addusers_modal').modal({backdrop:'static'});
});



$('.submitUsers').click(function(){
    var form = $('#adddealer_form').serialize();
    var html = "";var html2="";
    $.getJSON("{{URL::to('crew/adddealertocrew')}}",form,function(data){
         $.each(data.dealers,function(i,val){
            var co = '';
            if(val.msg.status=="success"){
                 toastr.success(val.msg.msg);
                 if(val.type=="crewmanager"){
                    co = 'btn-success';
                 } else if(val.type=="vanmanager"){
                    co = 'btn-primary';
                 } else {
                    co = 'btn-inverse';
                 }
                 html+="&nbsp;<span class='btn "+co+" removeItem'  data-id='"+val.id+"'>"+val.name+"</span>";
            } else {
                toastr.error(val.msg.msg);
            }
         });
         $.each(data.cities,function(i,val){
            if(val.msg.status=="success"){
                 toastr.success(val.msg.msg);
                 html2+="&nbsp;&nbsp;<span class='btn btn-inverse removeItem'  data-id='"+val.id+"'>"+val.name+"</span>";
            } else {
                toastr.error(val.msg.msg);
            }
         });
         $('#addusers_modal').modal('hide');
         $('.crewdealers-'+data.crew_id).append(html);
          $('.crewcities-'+data.crew_id).append(html2);
    });   
});

$(document).on('click','.deleteCrew',function(){
var crew_id = $(this).data('crew');
  if(confirm("Are you sure you want to delete this crew?")){
        var url = "../crew/crewdelete/"+crew_id;
            $.getJSON(url, function(data) {
             $('#crewrow-'+crew_id).hide();
			 toastr.success('Crew has been Deleted', 'SUCCESS!');
            });
    }
});

});
</script>
@endsection