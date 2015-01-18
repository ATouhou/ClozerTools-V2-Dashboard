@layout('layouts/main')
@section('content')

<script>

function showBatchForm(){
$('#addnewinventory').hide();
$('#inventorytable').hide();
$('#stats2').hide();
$('#batchmove').fadeIn(500);
}

function showAddForm(){
$('#addnewinventory').fadeIn(500);
$('#inventorytable').hide();
$('#stats2').hide();
$('#batchmove').hide();
}

function showInventory(){
$('#addnewinventory').hide();
$('#stats2').hide();
$('#batchmove').hide();
$('#inventorytable').fadeIn(500);
}

function showStats(){
$('#stats2').toggle(800);
}

</script>
        
<style>
#addnewinventory {display:none;}
#stats2 {display:none;}
#checkout {display:none;}
#batchmove {display:none;}
</style>
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside>
            @render('layouts.managernav')
            <div class="number-stats">
                <center><h4>Units In-Stock</h4></center>
                <ul>
                    <li>
                        @if(!empty($majestic))
                        {{$majestic}}@endif
                        <span>Majestics</span>
                    </li>
                    <li>
                        @if(!empty($defender))
                        {{$defender}}@endif
                        <span>Defenders</span>
                    </li>
                    <li>
                        @if(!empty($attach))
                        {{$attach}}@endif
                        <span>Attachments</span>
                    </li>
                </ul>
            </div>
            <div class="divider"></div>
            <!-- end aside item: Tiny Stats -->
                
            <!-- aside buttons -->
            <div class="aside-buttons">
                <a href="javascript:void(0)" title="" class="btn btn-primary" onclick="showAddForm();">ADD NEW BATCH</a>
            </div>
            <div class="divider"></div>
            <!-- end aside buttons -->
            
        </aside>
        <!-- aside end -->
                
               
                

                <div id="page-content">

                    <!-- page header -->
                    <h1 id="page-header">Full Inventory List</h1>   
                    <div class="fluid-container">
                        
                    
                        
                        @if($errors->has('sku'))
                        <div class="alert adjusted alert-warning">
                        <button class="close" data-dismiss="alert">×</button>
                        <i class="cus-exclamation-octagon-fram"></i>
                        <strong> < WARNING ></strong> 
                        
                       #{{Session::get('skus')}} has already been entered into the system!  Please Try Again...
                    
                        </div>
                        @endif

                        <!-- widget grid -->
                        <section id="widget-grid" class="">
                        
                        
                        <div class="row-fluid" id="inventorytable">
                            <article class="span12">
   




                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" data-widget-togglebutton="false" >
                                        <header>
                                            <h2>INVENTORY</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <table class="table table-bordered responsive" id="dtable3" >
                                                    <thead>
                                                        <tr>
                                                            <th>SKU #</th>
                                                            <th>UNIT NAME</th>
                                                            <th>Date Received</th>
                                                            <th>Date Sold</th>
                                                            <th>LOCATION</th>
                                                            <th>STATUS</th>
                                                            <th>Sold By</th>
                                                            <th>Checked Out By</th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                     @foreach($inventory as $val)
                                                    <?php if($val->status=="In Stock")
                                                    {$class="success";$stat="label label-success";} 
                                                    elseif($val->status=="Sold") 
                                                    {$class="SOLD";$stat="label label-success special";} 
                                                    elseif($val->status=="Checked Out")
                                                    {$class="info";$stat="label label-info";}
                                                    elseif($val->status=="Waiting Approval")
                                                    {$class="NA";$stat="label label-warning";}
                                                    else {$class="";$stat="label";}
                                                    ?>

                                                     <tr class="{{$class}} item-{{$val->id}}">
                                                        <td><b><span class='edit' id="sku|{{$val->id}}">{{$val->sku}}</span></b></td>
                                                        <td>{{ucfirst($val->item_name)}}</td>
                                                        <td class="edit" id="date_received|{{$val->id}}">{{$val->date_received}}</td>
                                                        <td>@if($val->date_sold!="0000-00-00"){{$val->date_sold}}@endif</td>
                                                        <td class="center">{{$val->location}}</td>
                                                        <td class="center">@if($val->status=="SOLD")
                                                            <a href="{{URL::to('sales/viewsale/')}}"><button class="btn btn-default">VIEW SALE</button></a>
                                                                @else
                                                                <span class="{{$stat}}">{{$val->status}}</span>
                                                                @endif
                                                        </td>
                                                        <td>{{$val->sold_by}}</td>
                                                        <td id="{{$val->id}}">
                                                        @if(($val->checked_by!="")&&($val->status!="Sold"))
                                                        <a href="{{URL::to('inventory/return/')}}{{$val->id}}"><button class="btn btn-primary btn-mini"><i class="cus-arrow-left"></i>&nbsp;Return To Stock</button></a><strong>&nbsp;&nbsp;Assigned To {{strtoupper($val->checked_by)}}</strong> &nbsp;&nbsp;  
                                                        @endif
                                                        @if($val->checked_by=="")
                                                        <select name="repdispatch" id="repdispatch-{{$val->id}}">
                                                            <option></option>
                                                            @if(!empty($reps))
                                                            @foreach($reps as $val2)
                                                            <option value="{{$val2->firstname}} {{$val2->lastname}}">{{$val2->firstname}} {{$val2->lastname}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
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
                        </section>
                        <!-- end widget grid -->
                    </div>      
                </div>
                <!-- end main content -->
            
                   <!-- aside right on high res -->
                <aside class="right">
                 @render('layouts.chat')
                 <div class="divider"></div>
                <!-- date picker -->
                    <div id="datepicker"></div>
                    
                    <!-- end date picker -->
                </aside>
                <!-- end aside right -->
                
                <!-- end aside right -->
            </div>
            
        </div><!--end fluid-container-->
        <div class="push"></div>
    </div>
    <!-- end .height wrapper -->

<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
$('#inventory').addClass('expanded');

$('.edit').editable('{{URL::to("inventory/edit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK'
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
            "iDisplayLength":50,
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

$('#skus').tagsInput({
   'height':'400px',
   'width':'400px',
   'maxChars' : 10,
   'defaultText':'Enter SKU#s',
});


$('#skubatch').tagsInput({
   'height':'90px',
   'width':'420px',
   'maxChars' : 10,
   'defaultText':'Enter SKU#s',
});


$('#skunums').change(function(){
    var sku = $(this).val();
    $('#skubatch').addTag(sku);
});

$('.sendtorep').click(function(){
    var id=$(this).data('id');
    var rep=$('#repdispatch-'+id).val();
    var url = "../inventory/dispatch";
    var url2 = "../inventory/return";
    if(rep.length>0){
        $.ajax({
        type: "POST",
        url: url,
        data: {id:id,rep:rep},
            beforeSend: function(){},
            success: function() {
            var html = "<a href='"+url2+"/"+id+"'><button class='btn btn-primary btn-mini'><i class='cus-arrow-left'></i>&nbsp;Return To Stock</button></a><strong>&nbsp;&nbsp;Assigned To "+rep.toUpperCase()+"</strong>&nbsp;&nbsp;&nbsp;";
            $('td#'+id).html(html);
            toastr.success('Machine has been sent to '+rep, 'SUCCESSFULLY ASSIGNED MACHINE');
            }
    }); 
    }
});

});
</script>
@endsection