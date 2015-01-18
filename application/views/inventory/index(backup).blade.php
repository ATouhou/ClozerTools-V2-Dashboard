@layout('layouts/main')
@section('content')

<script>
function showAddForm(){
$('#addnewinventory').toggle(500);
}
</script>
<style>
.statbox {margin-top:30px;}
.inventorystats {margin-top:20px;height:420px;}
#addnewinventory {display:none;}
#inventorytable {display:none;}
#stats2 {display:none;}
#checkout {display:none;}
#batchmove {display:none;}
.sendtorepform {
float:left;
margin-top:20px;
margin-left:20px;
width:90%;
}
.sendtorepform select {
    height:20%;
}
.sendtorepform label {
    font-size:70%;
    margin-bottom:-6px;
    margin-top:-10px;
}
.signoutbutton {margin-top:10px;}
</style>
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside>
            @render('layouts.managernav')
        </aside>
            <div id="page-content">
                <h1 id="page-header">Inventory Management 
                </h1>   
                    <div class="fluid-container">
                        <div class="row-fluid">
                            <article class="span8" id="addnewinventory" >
                                <h2>Add Inventory Batch</h2>
                                <hr style="border:1px dashed #ddd">
                                    <form class="form-horizontal " id="payform" method="post" action="{{URL::to('inventory/add')}}">
                                        <fieldset>
                                             <h4>BATCH INFORMATION</h4>
                                            <div class="control-group" style="margin-bottom:20px;">
                                                <label class="control-label">RECEIVING DATE</label>
                                                <div class="controls">
                                                    <div class="input-append date" id="datepicker-js" data-date="<?php echo date('Y-m-d');?>" data-date-format="yyyy-mm-dd">
                                                        <input class="datepicker-input" id="date" name="date" size="26" type="text" value="<?php echo date("Y-m-d");?>" placeholder="Select a date" />
                                                        <span class="add-on"><i class="cus-calendar-2"></i></span>
                                                </div>
                                                </div>
                                            <label class="control-label" style="margin-top:20px;">UNIT TYPE</label>
                                            <div class="controls" style="margin-top:20px;">
                                                <select id="unittype" name="unittype" class="span6">
                                                     <option value='defender'>DEFENDER</option>
                                                     <option value='majestic'>MAJESTIC</option>
                                                     <option value='attachment'>ATTACHMENT</option>
                                                    
                                                </select>
                                            </div>
                                               <label class="control-label"  style="margin-top:20px;">ASSIGN A CITY</label>
                                              <div class="controls" style="margin-top:20px;">
                                                <select id="cityname" name="cityname" class="span6">
                                                    @foreach($cities as $val)
                                                    <option value="{{$val->cityname}}">{{$val->cityname}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            </div>
                                        </fieldset>
                                             
                                        <fieldset>
                                        <h4 style="margin-top:20px;">SKU #'s</h4>
                                            <div class="control-group">
                                                <label class="control-label" for="input01"><b>SKU LIST</b></label>
                                                <div class="controls">
                                                <input id="skus" value="" name="tags" />
                                                </div>
                                           </div>
                                        </fieldset>  
                                        <br><br>
                                        <hr style="border:1px dashed #ddd">
                                    <button title="" class="btn btn-primary btn-large" style="margin-left:10px;margin-top:10px;margin-bottom:250px">ADD NEW INVENTORY</button>
                                    </form>
                                    <hr style="border:1px dashed #ddd">
                            </article>
                        

                        </div>


                        <div class="row-fluid" id="fullinventorytable">
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" data-widget-togglebutton="false" >
                                        <header>
                                            <h2>INVENTORY</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <style>
                                        #enterone {float:left; margin-left:20px;padding-bottom:20px;}
                                        #dtable3 input {width:55%!important;float:left;}
                                        #dtable3 select {width:90%!important;float:left;}

                                        </style>
                                        <div>
                                            <div class="inner-spacer">
                                                <table class="table table-bordered table-condensed responsive" id="dtable3">
                                                    <thead>
                                                        <tr><td></td><td>Enter New Item (SKU #)</td><td>Pick Type</td><td>Receive Date</td><td>Pick City (optional)</td><td>Assign Rep (optional)</td><td></td><td></td><td></td></tr>
                                                        <tr style='padding:10px;'>
                                                            <td></td>
                                                            <td>
                                                                 <form id="enteroneitem" action="" method="post">
                                                                <input type="text" name="sku" id="one-sku" maxlength="8" placeholder="SKU #">
                                                            </td>
                                                            <td>
                                                                <select name="machine" id="one-machine" placeholder="Machine Type">
                                                                    <option value="" disabled='disabled' selected='selected'>Type</option>
                                                                    @foreach($machinelist as $val)
                                                                    @if((strtolower($val->name)=="defender")||(strtolower($val->name)=="majestic")||(strtolower($val->name)=="attachment"))
                                                                    <option value="{{strtolower($val->name)}}">{{$val->name}}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="input-append date" id="datepicker-js" data-date="{{date('Y-m-d')}}" data-date-format="yyyy-mm-dd">
                                                                <input class="datepicker-input" size="16" id="one-entrydate" name="one-entrydate" type="text" value="{{date('Y-m-d')}}" placeholder="Select a date" />
                                                                <span class="add-on"><i class="cus-calendar-2"></i></span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select name="city" id="one-city" placeholder="Machine Type">
                                                                    <option value="" disabled='disabled' selected='selected'>Select City</option>
                                                                     @foreach($cities as $val)
                                                                    <option value="{{$val->cityname}}">{{$val->cityname}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td> <select name="rep" id="one-rep" placeholder="Machine Type">
                                                                    <option value="" disabled='disabled' selected='selected'>Assign a Rep</option>
                                                                    @foreach($reps as $val2)
                                                                    <option value="{{$val2->id}}">{{$val2->firstname}} {{$val2->lastname}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><center><button class='btn btn-success addItem'><i class='cus-add'></i>&nbsp;&nbsp;ADD THIS ITEM</button></center></td>
                                                        </tr>
                                                        </form> 
                                                        <tr>
                                                            <th>DEL</th>
                                                            <th style="width:10%;">SKU #</th>
                                                            <th>UNIT NAME</th>
                                                            <th style="width:8%;">Date Received</th>
                                                            <th style="width:8%;">Date Sold</th>
                                                            <th style="width:9%;">LOCATION</th>
                                                            <th>STATUS</th>
                                                            <th>Sold By</th>
                                                            <th>Checked Out By</th>
                                                        </tr>

                                                    </thead>
                                                    <tbody class="inventory">
                                                    @foreach($inventory as $val)
                                                    <?php if($val->status=="In Stock")
                                                    {$class="success";$stat="label label-success";} 
                                                    elseif($val->status=="Sold") 
                                                    {$class="SOLD";$stat="label label-success special blackText";} 
                                                    elseif($val->status=="Checked Out")
                                                    {$class="info";$stat="label label-info";}
                                                    elseif($val->status=="Waiting Approval")
                                                    {$class="NA";$stat="label label-warning";}
                                                    else {$class="";$stat="label";}

                                                    if($val->item_name=="defender"){$type="inverse";}elseif($val->item_name=="majestic"){$type="success";}else{$type="info";}
                                                    ?>

                                                     <tr class="{{$class}} {{$val->location}} item-{{$val->id}}" id="item-{{$val->id}}">
                                                        <td>@if($val->status=="In Stock")
                                                            <center>
                                                                <button class="btn btn-danger btn-mini deleteitem" data-id="{{$val->id}}">X</button>
                                                            </center>
                                                            @endif
                                                        </td>
                                                        <td><b><span class='edit' id="sku|{{$val->id}}">{{$val->sku}}</span></b><br/>
                                                            <button class="btn btn-default btn-mini viewHistory" data-sku="{{$val->sku}}">VIEW HISTORY</button>
                                                        </td>
                                                        <td><span class="label label-{{$type}}">{{ucfirst($val->item_name)}}</span>
                                                        </td>
                                                        <td class="edit tooltwo" title="Click to change Receive Date" id="date_received|{{$val->id}}">
                                                            <center>
                                                            {{$val->date_received}}
                                                            </center>
                                                        </td>
                                                        <td>@if($val->date_sold!="0000-00-00")
                                                            <a class="tooltwo" title="Click to View Sale # {{$val->sale_id}}" href='{{URL::to("reports/sales")}}?startdate={{$val->date_sold}}&enddate={{$val->date_sold}}' target=_blank>
                                                            <center>
                                                                {{$val->date_sold}}
                                                            </center>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td class="center editcity tooltwo" title="Click to Change City of this Machine" id="location|{{$val->id}}">
                                                            {{$val->location}}
                                                        </td>
                                                        <td class="center">
                                                            @if($val->status=="Sold" && $val->sale_id!=0)
                                                            <a class="tooltwo" title="Click to View Sale # {{$val->sale_id}}" href='{{URL::to("reports/sales")}}?startdate={{$val->date_sold}}&enddate={{$val->date_sold}}' target=_blank>
                                                            @endif
                                                            <span class="{{$stat}}" >{{strtoupper($val->status)}}
                                                                @if($val->status=="Sold" && $val->sale_id!=0)
                                                                | Sale # : {{$val->sale_id}}
                                                                @endif
                                                            </span>
                                                            @if($val->status=="Sold" && $val->sale_id!=0)
                                                            </a>
                                                            @endif 
                                                           
                                                        </td>
                                                        <td>{{$val->sold_by}}</td>
                                                        <td id="{{$val->id}}">
                                                        @if($val->checked_by!="")
                                                            @if($val->status=="Sold")
                                                            <span class='label label-inverse'>SOLD BY {{strtoupper($val->sold_by)}}</span>
                                                            @else
                                                            <a href="{{URL::to('inventory/return/')}}{{$val->id}}?tableview=yes">
                                                                <button class="btn btn-primary btn-mini">
                                                                    <i class="cus-arrow-left"></i>&nbsp;Return To Stock
                                                                </button>
                                                            </a><strong>&nbsp;&nbsp;Assigned To {{strtoupper($val->checked_by)}}</strong> &nbsp;&nbsp;
                                                            @endif  
                                                        @else
                                                        <select name="repdispatch" id="repdispatch-{{$val->id}}" style="width:45%!important;">
                                                            <option></option>
                                                            @foreach($reps as $val2)
                                                            <option value="{{$val2->id}}">{{$val2->firstname}} {{$val2->lastname}}</option>
                                                            @endforeach
                                                        </select>&nbsp;
                                                        <button class="btn btn-mini btn-default sendtorep" data-id="{{$val->id}}">SEND TO REP</button>
                                                        @endif
                                                        </td>
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

                        <div class="row-fluid" id="inventorybycity">
                                
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            <h2>MACHINES IN CITIES AT A GLANCE</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                          
                                                <table class="table table-bordered table-condensed responsive"  >
                                                    <thead>
                                                        <tr align="center">
                                                            <th>City</th>
                                                            <th>Defenders</th>
                                                            <th>Majestics</th>
                                                            <th>Attachments</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($stats as $val)
                                                    <tr id="">
                                                        <td><strong style="color:#000">{{strtoupper($val->location)}}</strong></td>
                                                        <td><center>@if($val->def!=0)<span class='label label-info special'>{{$val->def}}<span>@endif</center></td>
                                                        <td><center>@if($val->maj!=0)<span class='label label-info special'>{{$val->maj}}</span>@endif</center></td>
                                                        <td><center>@if($val->att!=0)<span class='label label-info special'>{{$val->att}}</span>@endif</center></td>
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


                        </div>




                    </div>      
                </div>
                <!-- end main content -->
            
                   <!-- aside right on high res -->
                <aside class="right">
                 @render('layouts.chat')
                 <div class="divider"></div>
               
                </aside>
                <!-- end aside right -->
                
                <!-- end aside right -->
            </div>
            
        </div><!--end fluid-container-->
        <div class="push"></div>
    </div>
    <!-- end .height wrapper -->
<?php 
$arr2=array();
foreach($cities as $val2){
     $arr2[$val2->cityname]=$val2->cityname;
};
?>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
$('#inventory').addClass('expanded');

$('body').on('click','.deleteitem',function(){
var id=$(this).data('id');
var t = confirm("Are you sure you want to delete this item??");
if(t){
    $.get('inventory/deleteitem/'+id, function(data){
        $('#item-'+id).hide();
        toastr.success("Item succesfully removed!");
    });
}
});

$('.addItem').click(function(){
var sku = $('#one-sku').val();
var type = $('#one-machine').val();
var rep = $('#one-rep').val();
var city = $('#one-city').val();
var date = $('#one-entrydate').val();
if((sku=="")||(type=="")){
    if(type==""){
        toastr.error('Please Select an Inventory Type', 'Missing MACHINE TYPE');
    }
    if(sku==""){
        toastr.error('Please enter valid SKU', 'Missing SKU!');
    } 
    return false;
}
d = {sku: sku, type: type, rep:rep, city:city, date:date};
    $.get('inventory/additem',d, function(data){
        if(data=="failed"){
        return false;
    } else if(data=="alreadyin"){
        toastr.error("This serial number already exists for the Item Type you are trying to enter!!","NUMBER EXISTS!");
    } else {
         location.reload();   
        }
    });
});

$('#one-sku').keyup(function(){
    var t = $(this).val();
    if(t.length!=8){
        return false;
    } else {
        $.get('inventory/checksku',{sku: t },function(data){
            if(data){
                toastr.warning('The SKU# you are trying to enter, already exists!  You can enter this number, but make sure the Item Type is different than the number already in system','SKU ALREADY IN SYSTEM!');
            } else {
                toastr.success('The SKU# you entered is new, and is valid!','SKU VALID');
            }
        });
    }
});

$('.edit').editable('{{URL::to("inventory/edit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK',
         callback : function(){
            toastr.success("Succesfully Edited","SUCCESS");
         }
});

$(document).on('click','.viewHistory',function(){
    var id=$(this).attr('data-sku');
        var url = '{{URL::to("inventory/history")}}/'+id;
        var type='inventory';
        $('.'+type+'InfoHover').addClass('animated fadeInUp').load(url).show();
});

$('.editcity').editable('{{URL::to("inventory/edit")}}',{
        data : '<?php echo  json_encode($arr2);?>',
        type:'select',
        submit:'OK',
        indicator : 'Saving...',
        tooltip: 'Click to Change City',
        callback : function(){
            toastr.success("Succesfully Changed City","CITY CHANGED!");
         }
});


        
        $('#dtable3').dataTable({
            // define table layout
            "sDom" : "<'row-fluid dt-header'<'span6'f><'span6 hidden-phone'T>r>t<'row-fluid dt-footer'<'span6 visible-desktop'i><'span6'p>>",
            // add paging 
            "sPaginationType" : "bootstrap",
            "oLanguage" : {
                "sLengthMenu" : "Showing: 25",
                "sSearch": "" 
            },
            "aaSorting": [],
            "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
            "iDisplayLength":25,
            "oTableTools": {
                "sSwfPath": "js/include/assets/DT/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                                     
                    //save for excel
                    {
                        "sExtends": "xls",
                        "sButtonText": '<i class="cus-doc-excel-table oTable-adjust"></i>'+" Save for Excel"
                    }
                ]
            } // end oTableTools settings
            
        }); // end datatable formating



$('body').on('click','.sendtorep',function(){
    var id=$(this).data('id');
    var rep=$('#repdispatch-'+id).val();
    var url = "inventory/dispatch";
    var url2 = "inventory/return";
    if(rep.length>0){
        $.ajax({
        type: "POST",
        url: url,
        data: {id:id,rep:rep},
            beforeSend: function(){},
            success: function(data) {
               var d = JSON.parse(data);
           var html = "<a href='"+url2+"/"+id+"?tableview=yes'><button class='btn btn-primary btn-mini'><i class='cus-arrow-left'></i>&nbsp;Return To Stock</button></a><strong>&nbsp;&nbsp;Assigned To "+d.attributes.checked_by.toUpperCase()+"</strong>&nbsp;&nbsp;&nbsp;";
            $('td#'+id).html(html);
            toastr.success('Machine has been sent to '+d.attributes.checked_by, 'SUCCESSFULLY ASSIGNED MACHINE');
            }
            
    }); 
    }
});




});
</script>
@endsection