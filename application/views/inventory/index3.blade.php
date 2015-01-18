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
#fullinventorytable {display:none;}
#stats2 {display:none;}
#checkout {display:none;}
#batchmove {display:none;}
.sendtorepform {float:left;
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
            <div class="number-stats">
                <center><h4>Units In-Stock</h4></center>
                <ul>
                    <li>
                        @if(!empty($maj))
                        {{count($maj)}}@endif
                        <span>Majestics</span>
                    </li>
                    <li>
                        @if(!empty($def))
                        {{count($def)}}@endif
                        <span>Defenders</span>
                    </li>
                    <li>
                        @if(!empty($att))
                        {{count($att)}}@endif
                        <span>Attachments</span>
                    </li>
                </ul>
            </div>
            <div class="divider"></div>
            <!-- end aside item: Tiny Stats -->
            
        </aside>
            <div id="page-content">
                <h1 id="page-header">Inventory Management 
                    <button class="btn btn-success addnew" onclick="showAddForm();" style="float:right;margin-right:20px;margin-top:10px">
                        <i class="cus-add"></i>&nbsp;ADD NEW INVENTORY
                    </button>
                    <button class="btn btn-primary" onclick="$('#fullinventorytable').toggle(200);" style="float:right;margin-right:20px;margin-top:10px">
                        <i class="cus-cart"></i>&nbsp;SHOW ALL INVENTORY
                    </button>
                </h1>   
                    <div class="fluid-container">

                        <div class="row-fluid" id="fullinventorytable">
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
                                                <table class="table table-bordered table-condensed responsive" id="dtable3">
                                                    <thead>
                                                        <tr>
                                                            <th>DEL</th>
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
                                                    <tbody class="inventory">
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

                                                    if($val->item_name=="defender"){$type="inverse";}elseif($val->item_name=="majestic"){$type="success";}else{$type="info";}
                                                    ?>

                                                     <tr class="{{$class}} {{$val->location}} item-{{$val->id}}" id="item-{{$val->id}}">
                                                        <td>@if($val->status=="In Stock")
                                                            <center>
                                                                <button class="btn btn-danger btn-mini deleteitem" data-id="{{$val->id}}">X</button>
                                                            </center>
                                                            @endif
                                                        </td>
                                                        <td><b><span class='edit' id="sku|{{$val->id}}">{{$val->sku}}</span></b></td>
                                                        <td><span class="label label-{{$type}}">{{ucfirst($val->item_name)}}</span></td>
                                                        <td class="edit" id="date_received|{{$val->id}}">{{$val->date_received}}</td>
                                                        <td>@if($val->date_sold!="0000-00-00")<center>{{$val->date_sold}}</center>@endif</td>
                                                        <td class="center">{{$val->location}}</td>
                                                        <td class="center">
                                                            @if($val->status=="Sold")
                                                            <a href="{{URL::to('sales/viewsale/')}}{{$val->sale_id}}">
                                                                <button class="btn btn-default btn-mini">VIEW SALE</button>
                                                            </a>
                                                            <span class="{{$stat}}">{{$val->status}}</span>  
                                                            @else
                                                            <span class="{{$stat}}">{{$val->status}}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{$val->sold_by}}</td>
                                                        <td id="{{$val->id}}">
                                                        @if($val->checked_by!="")
                                                            @if($val->status=="Sold")
                                                            <span class='label label-inverse'>SOLD BY {{strtoupper($val->sold_by)}}</span>
                                                            @else
                                                            <a href="{{URL::to('inventory/return/')}}{{$val->id}}">
                                                                <button class="btn btn-primary btn-mini">
                                                                    <i class="cus-arrow-left"></i>&nbsp;Return To Stock
                                                                </button>
                                                            </a><strong>&nbsp;&nbsp;Assigned To {{strtoupper($val->checked_by)}}</strong> &nbsp;&nbsp;
                                                            @endif  
                                                        @else
                                                        <select name="repdispatch" id="repdispatch-{{$val->id}}">
                                                            <option></option>
                                                            @foreach($reps as $val2)
                                                            <option value="{{$val2->id}}">{{$val2->firstname}} {{$val2->lastname}}</option>
                                                            @endforeach
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


                        <div class="row-fluid">


                        <div class="well span4 inventorystats">
                        <h2>DEFENDERS <img src="{{URL::to_asset('images/pureop-def.png')}}" width=75px style="margin-top:-10px;"></h2>   
                            <div class="largestats ">
                                <span class="bignum2 BOOK">{{count($def)}}</span><br/><br/>
                                <h5>In Stock</h5>
                            </div>
            
                            <div class="largestats ">
                                <span class="bignum2 PUTON">{{Inventory::where('item_name','=','defender')->where('status','=','Checked Out')->count()}}</span><br/><br/>
                                <h5>Checked Out</h5>
                            </div>

                              <div class="sendtorepform">
                                 <form id="checkoutform" method="post" action="{{URL::to('inventory/checkout')}}">
                          
                            @if($errors->has('city'))<span class="label label-important">{{$errors->first('city')}}</span>  @else <label for="city">Pick City</label> @endif
                            <select name="city">
                                @if(!empty($cities))
                                <option></option>
                                @foreach($cities as $val)
                                <option value="{{$val->cityname}}">{{$val->cityname}}</option>
                                @endforeach
                                @endif
                            </select>
                          
                             @if($errors->has('rep'))<span class="label label-important">{{$errors->first('rep')}}</span>  @else <label for="rep">Pick Sales Rep</label> @endif
                            <select name="rep" >
                                @if(!empty($reps))
                                <option></option>
                                @foreach($reps as $val)
                                <option value="{{$val->id}}">{{ucfirst($val->firstname)}} {{ucfirst($val->lastname)}}</option>
                                @endforeach
                                @endif
                            </select>
                            
                           
                             @if($errors->has('sku'))<span class="label label-important">{{$errors->first('sku')}}</span>  @else <label for="sku">Pick an SKU#</label> @endif
                            <select name="sku">
                                @if(!empty($def))
                                <option></option>
                                @foreach($def as $val)
                                <option value="{{$val->id}}">{{$val->sku}} &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; {{$val->date_received}}</option>
                                @endforeach
                                @endif
                            </select>
                            <button class="btn btn-default btn-small signoutbutton"><i class="cus-accept"></i>&nbsp;SIGN OUT</button>
                            </form>
                            </div>
                        </div>


                        <div class="well span4 inventorystats" >
                        <h2>MAJESTICS  <img src="{{URL::to_asset('images/pureop-maj.png')}}" width=65px style="margin-top:-10px;margin-left:10px;"></h2> 
                        <div style="margin-top:20px;">
                            <div class="largestats ">
                                <span class="bignum2 BOOK">{{count($maj)}}</span><br/><br/>
                                <h5>In Stock</h5>
                            </div>
            
                            <div class="largestats ">
                                <span class="bignum2 PUTON">{{Inventory::where('item_name','=','majestic')->where('status','=','Checked Out')->count()}}</span><br/><br/>
                                <h5>Checked Out</h5>
                            </div>
                        </div>
                          <div class="sendtorepform">
                            <form id="checkoutform" method="post" action="{{URL::to('inventory/checkout')}}">
                   
                            @if($errors->has('city'))<span class="label label-important">{{$errors->first('city')}}</span>  @else <label for="city">Pick City</label> @endif
                            <select name="city">
                                @if(!empty($cities))
                                <option></option>
                                @foreach($cities as $val)
                                <option value="{{$val->cityname}}">{{$val->cityname}}</option>
                                @endforeach
                                @endif
                            </select>
                       
                             @if($errors->has('rep'))<span class="label label-important">{{$errors->first('rep')}}</span> @else <label for="rep">Pick Sales Rep</label> @endif
                            <select name="rep">
                                @if(!empty($reps))
                                <option></option>
                                @foreach($reps as $val)
                                <option value="{{$val->id}}">{{ucfirst($val->firstname)}} {{ucfirst($val->lastname)}}</option>
                                @endforeach
                                @endif
                            </select>
                            
                          
                             @if($errors->has('sku'))<span class="label label-important">{{$errors->first('sku')}}</span>   @else <label for="sku">Pick an SKU#</label> @endif
                            <select name="sku">
                                @if(!empty($maj))
                                <option></option>
                                @foreach($maj as $val)
                                <option value="{{$val->id}}">{{$val->sku}} &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; {{$val->date_received}}</option>
                                @endforeach
                                @endif
                            </select>
                            <button class="btn btn-default btn-small signoutbutton"><i class="cus-accept"></i>&nbsp;SIGN OUT</button>
                            </form>
                            </div>
                        </div>

                        <div class="well span4 inventorystats" >
                        <h2>ATTACHMENTS </h2>   
                        <div class="statbox">
                            <div class="largestats ">
                                <span class="bignum2 BOOK">{{count($att)}}</span><br/><br/>
                                <h5>In Stock</h5>
                            </div>
            
                            <div class="largestats ">
                                <span class="bignum2 PUTON">{{Inventory::where('item_name','=','attachment')->where('status','=','Checked Out')->count()}}</span><br/><br/>
                                <h5>Checked Out</h5>
                            </div>
                            
                            <div class="sendtorepform">
                            <form id="checkoutform" method="post" action="{{URL::to('inventory/checkout')}}">
                            
                            @if($errors->has('city'))<span class="label label-important">{{$errors->first('city')}}</span>  @else <label for="city">Pick City</label> @endif
                            <select name="city">
                                @if(!empty($cities))
                                <option></option>
                                @foreach($cities as $val)
                                <option value="{{$val->cityname}}">{{$val->cityname}}</option>
                                @endforeach
                                @endif
                            </select>
                             @if($errors->has('rep'))<span class="label label-important">{{$errors->first('rep')}}</span>  @else <label for="rep">Pick Sales Rep</label> @endif
                            <select name="rep">
                                @if(!empty($reps))
                                <option></option>
                                @foreach($reps as $val)
                                <option value="{{$val->id}}">{{ucfirst($val->firstname)}} {{ucfirst($val->lastname)}}</option>
                                @endforeach
                                @endif
                            </select>
                  
                             @if($errors->has('sku'))<span class="label label-important">{{$errors->first('sku')}}</span>  @else <label for="sku">Pick an SKU#</label> @endif
                            <select name="sku">
                                @if(!empty($att))
                                <option></option>
                                @foreach($att as $val)
                                <option value="{{$val->id}}">{{$val->sku}} &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp; {{$val->date_received}}</option>
                                @endforeach
                                @endif
                            </select>
                            <button class="btn btn-default btn-small signoutbutton"><i class="cus-accept"></i>&nbsp;SIGN OUT</button>
                            </form>
                            </div>


                        </div>
                        </div>



                        <div class="row-fluid" id="inventorybycity">
                                
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" >
                                        <header>
                                            <h2>MACHINES IN CITIES</h2>                           
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
                                                            <th>View SKU's</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($stats as $val)
                                                    <tr id="">
                                                        <td><strong style="color:#000">{{strtoupper($val->location)}}</strong></td>
                                                        <td><center>@if($val->def!=0)<span class='label label-info special'>{{$val->def}}<span>@endif</center></td>
                                                        <td><center>@if($val->maj!=0)<span class='label label-info special'>{{$val->maj}}</span>@endif</center></td>
                                                        <td><center>@if($val->att!=0)<span class='label label-info special'>{{$val->att}}</span>@endif</center></td>
                                                        <td><center><button class='btn btn-default btn-small viewcity' data-city="{{$val->location}}">VIEW CITY DETAILS</button></center></td>
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
                                                <table class="table table-bordered table-condensed responsive" >
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
                                                    <tbody class="inventory">
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

                                                    if($val->item_name=="defender"){$type="inverse";}elseif($val->item_name=="majestic"){$type="success";}else{$type="info";}
                                                    ?>

                                                     <tr class="{{$class}} {{$val->location}} item-{{$val->id}}">
                                                        <td><b><span class='edit' id="sku|{{$val->id}}">{{$val->sku}}</span></b></td>
                                                        <td><span class="label label-{{$type}}">{{ucfirst($val->item_name)}}</span></td>
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
                                                        @if($val->checked_by!="")
                                                        <a href="{{URL::to('inventory/return/')}}{{$val->id}}"><button class="btn btn-primary btn-mini"><i class="cus-arrow-left"></i>&nbsp;Return To Stock</button></a><strong>&nbsp;&nbsp;Assigned To {{strtoupper($val->checked_by)}}</strong> &nbsp;&nbsp;  
                                                        @else
                                                        <select name="repdispatch" id="repdispatch-{{$val->id}}">
                                                            <option></option>
                                                            @foreach($reps as $val2)
                                                            <option value="{{$val2->id}}">{{$val2->firstname}} {{$val2->lastname}}</option>
                                                            @endforeach
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

$('.viewcity').click(function(){
var city = $(this).data('city');
$('#inventorytable').fadeIn(200);
$('.inventory tr').hide();
$('tr.'+city).show();
});

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
    var url = "inventory/dispatch";
    var url2 = "inventory/return";
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

$('.deleteitem').click(function(){
var id=$(this).data('id');
var t = confirm("Are you sure you want to delete this item??");
if(t){
    $.get('inventory/deleteitem/'+id, function(data){
        $('#item-'+id).hide();
        toastr.success("Item succesfully removed!");
        console.log(data);
    });
}
});

});
</script>
@endsection