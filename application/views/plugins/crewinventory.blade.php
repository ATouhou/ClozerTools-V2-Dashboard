

@if(!empty($inventory))
<hr>
                        <h3>Crew Inventory for {{$crew->crew_name}}</h3>
                        <p>To sign out a machine to a rep, simply drag and drop the machine in the appropriate slot for the rep</p>

                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                                                   
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer" style="padding-bottom:30px;">
                                                    
                            
                                <div class="span4">
                                    <h5>In Stock Machines</h5>
                                 <table class="table table-striped table-bordered responsive"  >
                                                    <thead>
                                                        <tr align="center">
                                                            <th>MAJESTICS</th>
                                                            <th>DEFENDERS</th>
                                                            <th>ATTACHMENTS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php $def="";$maj="";$att="";?>
                                                      @if(!empty($inventory))
                                                      @foreach($inventory as $c)
                                                        @if(!empty($c['inventory']))
                                                            @foreach($c['inventory'] as $inv)
                                                                <?php if($inv->item_name=="defender"){
                                                                    $def.="<li class='animated tooltwo fadeInUp instock-li prod-defender' data-id='".$inv->id."' data-sku='".$inv->sku."' title='Machine is in ".$inv->location."' data-type='".$inv->item_name."'>".$inv->sku."</li>";
                                                                } else if($inv->item_name=="majestic"){
                                                                     $maj.="<li class='animated tooltwo fadeInUp instock-li prod-majestic' data-id='".$inv->id."' data-sku='".$inv->sku."' title='Machine is in ".$inv->location."' data-type='".$inv->item_name."'>".$inv->sku."</li>";
                                                                } else if($inv->item_name=="attachment"){
                                                                     $att.="<li class='animated tooltwo fadeInUp instock-li prod-attachment' data-id='".$inv->id."' data-sku='".$inv->sku."' title='Machine is in ".$inv->location."' data-type='".$inv->item_name."'>".$inv->sku."</li>";
                                                                };?>
                                                            @endforeach
                                                        @endif
                                                      @endforeach
                                                      @endif
                                                      <tr >
                                                        <td class="majestic-instock">{{$maj}}</td>
                                                        <td class="defender-instock">{{$def}}</td>
                                                        <td class="attachment-instock">{{$att}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="span6" style="margin-left:100px;padding:15px;border-radius:8px;background:#ddd;margin-top:20px;">
                                                 <h5>Signed out Machines</h5>
                                                <table class="table table-bordered " style="border:1px solid #1f1f1f;background:white;"  >
                                                    <thead>
                                                        <tr align="center">
                                                            <th>DEALER</th>
                                                            <th>MAJESTIC</th>
                                                            <th>DEFENDERS</th>
                                                            <th>ATTACHMENTS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                             @foreach($crew->members() as $m)
                                                              <?php if($m->type=="crewmanager"){$lab = "success";$t="is Crew Manager of this Road Crew";} 
                                                              else if($m->type=="vanmanager"){$lab = "primary";$t="is a Van Manager for this Road Crew";} 
                                                              else {$lab="inverse ";$t="is a Dealer in this Road Crew";}
                                                              $maj="";$def="";$att="";
                                                              $machines = $m->member->machines();
                                                              foreach($machines as $inv){
                                                                if($inv->item_name=="defender"){
                                                                    $def.="<span class='removeInventoryItem tooltwo' title='Click to return item to stock' data-sku='".$inv->sku."' data-type='".$inv->item_name."' data-id='".$inv->id."' >".$inv->sku."</span>";
                                                                } else if($inv->item_name=="majestic"){
                                                                     $maj.="<span class='removeInventoryItem tooltwo' title='Click to return item to stock' data-sku='".$inv->sku."' data-type='".$inv->item_name."' data-id='".$inv->id."' >".$inv->sku."</span>";
                                                                } else if($inv->item_name=="attachment"){
                                                                     $att.="<span class='removeInventoryItem tooltwo' title='Click to return item to stock' data-sku='".$inv->sku."' data-type='".$inv->item_name."' data-id='".$inv->id."' >".$inv->sku."</span>";
                                                                }
                                                              }
                                                              ;?>
                                                            <tr class="userInventory" id="user-{{$m->member->id}}">
                                                                <?php $name = $m->member->firstname." ".substr($m->member->lastname,0,1);?>
                                                                <td><span class='tooltwo btn btn-{{$lab}}' title='{{$name}} {{$t}}'>{{$name}}</span></td>
                                                                    <td class="majestic-contain" data-rep="{{$name}}" data-userid="{{$m->member->id}}">{{$maj}}</td>
                                                                    <td class="defender-contain" data-rep="{{$name}}" data-userid="{{$m->member->id}}">{{$def}}</td>
                                                                    <td class="attachment-contain" data-rep="{{$name}}" data-userid="{{$m->member->id}}">{{$att}}</td>
                                                            </tr>
                                                           
                                                           
                                                        @endforeach
                                                      
                                                    </tbody>
                                                </table>
                                            </div>
                                       


                                              
                                            </div>
                                            <!-- end content-->
                                        </div>
                                        <!-- end wrap div -->
                                    </div>
                                    <!-- end widget -->
@else
<h3>No Inventory in stock for the cities within this crew </h3>
<h5>Please move stock from the Inventory page to a city that belongs to a crew</h5>
@endif
<script>
$(document).ready(function(){

  $('.tooltwo').tooltipster();

  $( ".majestic-contain" ).droppable({
      activeClass: "",
      accept:".prod-majestic",
      hoverClass: "btn-success",
      drop: function( event, ui ) {
         var id = $(this).attr('data-userid');
         var rep = $(this).attr('data-rep');
         var item = $(this);
       addInventory(id,rep,item,ui.draggable,"majestic");
        }
    });

$( ".defender-contain" ).droppable({
      activeClass: "",
      accept:".prod-defender",
      hoverClass: "btn-success",
      drop: function( event, ui ) {
          var id = $(this).attr('data-userid');
         var rep = $(this).attr('data-rep');
          var item = $(this);
       addInventory(id,rep,item,ui.draggable,"defender");
        }
    });

$( ".attachment-contain" ).droppable({
      activeClass: "",
      accept:".prod-attachment",
      hoverClass: "btn-success",
      drop: function( event, ui ) {
         var id = $(this).attr('data-userid');
         var rep = $(this).attr('data-rep');
         var item = $(this);
       addInventory(id,rep,item,ui.draggable,"attachment");
        }
    });

function addInventory(id,rep,theitem,$item,type){
    var itemid = $item.attr('data-id');
    var sku = $item.attr('data-sku');
    var t = $item;
    $.getJSON("{{URL::to('inventory/dispatch')}}",{id:itemid,rep:id},function(data){
        if(data!="failed"){
             t.fadeOut();
             toastr.success("Successfully signed out "+sku+" to "+rep,type.toUpperCase()+" CHECK OUT");
             theitem.append("<span class='removeInventoryItem tooltwo' title='Click to return item to stock' data-sku='"+sku+"' data-type='"+type+"' data-id='"+itemid+"'>"+sku+"</span>");
        } else {
            toastr.error("FAILED TO ASSIGN MACHINE TO REP","FAILED!")
        }
    });
}

$(document).on('click','.removeInventoryItem',function(){
    var id = $(this).attr('data-id');
    var type=$(this).attr('data-type');
    var sku = $(this).attr('data-sku');
    var t = $(this);
    $.getJSON("{{URL::to('inventory/return/')}}"+id,function(data){
        t.hide();
        $('.'+type+'-instock').append("<li class='animated fadeInUp instock-li prod-"+type+"' data-sku='"+sku+"' data-id='"+id+"' data-type='"+type+"'>"+sku+"</li>");
        toastr.success("Succesfully returned item","ITEM RETURNED");
        makeDraggable();
    });
});
makeDraggable();

function makeDraggable(){

    $('tooltwo').tooltipster();

    $('.prod-majestic').draggable({
    cursor:'move',
    revert:'invalid'
});


$('.prod-attachment').draggable({
    cursor:'move',
    revert:'invalid'
});


$('.prod-defender').draggable({
    cursor:'move',
    revert:'invalid'
});
}



});

</script>