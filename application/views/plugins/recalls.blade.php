<style>
    .hiddenCity {
        display:none;
    }
</style>
@if(!empty($recalls))
<h1 id="page-header"><img src='{{URL::to("images/clozer-cup.png")}}' style='margin-right:-10px;'>&nbsp;Recall Manager</h1>   
            <div class="fluid-container"><br/>
                <span class='label label-warning special blackText'>&nbsp;&nbsp;{{count($recalls)}} RECALLS  &nbsp;&nbsp;<button class='btn btn-default btn-small showInactiveCities'>Show Inactive Cities</button></span>
                <br/><br/>
                You can manually release any lead back into the Lead Pool from here.<br/>
                <br/>
               <span style="color:red;">NOTE :  Bookers are now able to see any recalls past due,  that THEY marked as Recall, from their login/booking page <br/>
                (provided the INCLUDE RECALLS IN SORT checkbox is NOT checked)<br/>
               <br/>
               If you check the box, then the leads automatically get sorted back into the pool, with no memory of who marked it as a Recall, and it becomes a regular lead again.
               </span>


                <br/></span>
                    <div class="pull-right" style="margin-top:-38px;margin-roght:20px;">
                    <input type="checkbox" class="myinput large includeRecalls tooltwo " title="Click this to include all Recalls past their call back date in the lead sort.  This will put them back into the pool, to be assigned" data-field="sort_recalls" name="available" id="available" @if(Setting::find(1)->sort_recalls==1) checked='checked' @endif />    &nbsp;&nbsp;&nbsp;INCLUDE RECALLS IN SORT</div>
        
                <section id="widget-grid" class="">
                    <table class="leadtable responsive table table-bordered">
                        <thead>
                            <tr><th style="width:9%;">LAST CALL DATE</th>
                                <th style="width:7%;">RECALL DATE</th>
                                <th>Booker</th>
                                <th style="width:13%;">Leadtype</th>
                                <th style="width:10%;">Num</th>
                                <th>Name</th>
                                <th>NOTES</th>
                                <th style="width:18%;"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($recalls as $val)
                                @foreach($cities as $c)
                                    <?php
                                        if($val->city==$c->cityname){
                                            $cl = "hiddenCity";
                                        } else {
                                            $cl = "";
                                        }
                                    ;?>
                                @endforeach
                            <?php if($val->leadtype=="rebook"){$icon2="cus-arrow-redo"; } else {$icon2="";}
                                    if($val->original_leadtype=="door"){$icon="cus-door";$val->original_leadtype="Door Survey";} 
                                    else if($val->original_leadtype=="paper"){$icon="cus-script";$val->original_leadtype="Manilla Survey";}
                                    else if($val->original_leadtype=="secondtier"){$icon="cus-script";$val->original_leadtype="Second Tier";}
                                    else if($val->original_leadtype=="ballot"){$icon="cus-inbox";$val->original_leadtype="Ballot Box";}
                                    else if($val->original_leadtype=="hoemshow"){$icon="cus-home";$val->original_leadtype="Home Show";}  
                                    else if($val->original_leadtype=="other"){$icon="cus-zone-money";$val->original_leadtype="Scratch Card";} 
                                    else if($val->original_leadtype=="referral"){$icon="cus-user";$val->original_leadtype="Referral";} 
                                    else if($val->original_leadtype=="personal"){$icon="cus-user";$val->original_leadtype="Personal Lead";} 
                                    else if($val->original_leadtype=="coldcall"){$icon="cus-telephone";$val->original_leadtype="Cold Call";} 
                                    else if($val->original_leadtype=="doorknock"){$icon="cus-door";$val->original_leadtype="Door Knock";} 

                                    else {$icon="";};
                                    ?>
                            <tr class="recallRow {{$cl}}" id="recallLead-{{$val->id}}"><td>{{$val->call_date}}</td>
                                <td>
                                    @if($val->recall_date>date('Y-m-d') )
                                    <span class='badge badge-important special tooltwo' title="There is still time left on these Recalls, they will remain here in quarantine until {{$val->recall_date}}">
                                    @else
                                    <span class='badge badge-success special tooltwo' title="Recall date has been passed! Sorting the leads, will release these leads or you can release them manually if you chose">
                                    @endif
                                    {{$val->recall_date}}
                                    </span>
                                </td>
                                <td>{{$val->booker_name}}</td>
                                <td><i class='{{$icon}}'></i>&nbsp;&nbsp;{{$val->original_leadtype}} @if($val->leadtype=="rebook") <br/><span class="badge badge-info special">Rebook</span> @endif</td>
                                <td><span class="label label-inverse searchNum tooltwo" title="Click to search this lead above">{{$val->cust_num}}</span></td>
                                <td>{{$val->cust_name}}</td>
                                <td>
                                    <span class="edit" id="notes|{{$val->id}}">{{$val->notes}}</span>
                                </td>
                                <td>
                                    <button class="btn btn-small btn-default releaseRecall" data-id="{{$val->id}}" data-notes=0><i class="icon-arrow-left"></i>&nbsp;&nbsp;Just Release</button>
                                    @if(Setting::find(1)->shortcode!="be")
                                    <button class="btn btn-small btn-primary releaseRecall" data-id="{{$val->id}}" data-notes=1><i class="icon-arrow-left"></i>&nbsp;&nbsp;Release and Clear Notes</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
            <script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){

    $('.showInactiveCities').click(function(){
        $('.hiddenCity').toggle();
    });

    $('.includeRecalls').click(function(){
        var field = $(this).data('field');
        t = $(this);
        if($(this).is(":checked")){
            var value=1;
        } else {
            var value=0;
        }
        $.get('{{URL::to("settings/edit")}}',{field:field, value:value},function(data){
        if(data==1) {
            toastr.success('Settings saved successfully!','RECALLS INCLUDED TO SORT');
        } else if(data=="failed"){
            toastr.error('Failed! Contact webmaster','Uncheck failed!!!');
        } else {
             toastr.success('Settings saved successfully!','EXCLUDED RECALLS FROM SORTING');
        };
        });

});


$('.edit').editable('{{URL::to("lead/edit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK',
         loaddata : function(value, settings) {
       return {foo: "bar"};
   }
});
$('.tooltwo').tooltipster();
$('.releaseRecall').click(function(){
    var id = $(this).data('id');
    var notes = $(this).data('notes');

    $.getJSON('{{URL::to("lead/releaserecall")}}',{theid:id, notes:notes},function(data){
        if(data=="success"){
            $('tr#recallLead-'+id).addClass('animated fadeOutUp');
            setTimeout(function(){
                    $('tr#recallLead-'+id).hide();
            },800);
            if(notes){
                toastr.success("Notes cleared, and Lead resleased","LEAD RELEASED / NOTES CLEARED");
            } else {
                toastr.success("Lead realeased back into pool","LEAD RELEASED");
            }
            
        }
        console.log(data);
    });
});


});
</script>
@else
<h3>There are no Recalls in the system</h3>
@endif