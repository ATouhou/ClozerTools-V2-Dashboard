@layout('layouts/main')
@section('content')
<?php if(Auth::user()->user_type=="manager"){$your = "";} else {$your = "YOUR";}?>
<script>

function showForm(){
$('#teamstats').hide();
$('#intro').hide();
$('#saleview').hide();
$('#stats').hide();
$('#salestable').hide();
$('#submitpayform').fadeIn(500);
}

function showTable(){
$('#teamstats').hide();
$('#saleview').hide();
$('#intro').hide();
$('#stats').hide();
$('#submitpayform').hide();
$('#salestable').fadeIn(500);

}

function showStats(){
$('#teamstats').hide();
$('#intro').hide();
$('#saleview').hide();
$('#submitpayform').hide();
$('#salestable').hide();
$('#stats').fadeIn(800);

}
</script>

<style>
#saleview {display:none;}
#submitnewsale {display:none;}
#stats {display:none;}
.paybox {background: #e2e2e2; 
background: -moz-linear-gradient(top,  #e2e2e2 0%, #dbdbdb 50%, #d1d1d1 51%, #fefefe 100%); 
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e2e2e2), color-stop(50%,#dbdbdb), color-stop(51%,#d1d1d1), color-stop(100%,#fefefe));
background: -webkit-linear-gradient(top,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%);
background: -o-linear-gradient(top,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); 
background: -ms-linear-gradient(top,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); 
background: linear-gradient(to bottom,  #e2e2e2 0%,#dbdbdb 50%,#d1d1d1 51%,#fefefe 100%); 
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#fefefe',GradientType=0 ); 
height:100px;margin-bottom:20px;border:1px solid #1f1f1f;-moz-box-shadow:    inset 0 0 10px #000000;
   -webkit-box-shadow: inset 0 0 10px #000000;
   box-shadow:         inset 0 0 10px #000000;}
.paybox h5 {margin-left:20px;}
.paybox div {margin:auto;width:30%;20px;text-align:center;font-size:240%;color:#fff;padding:10px;background:#1f1f1f;border-radius:5px;}

</style>
      
        <div id="main" role="main" class="container-fluid">
            <div class="contained">
                <!-- aside -->  
                <aside> 
                    @render('layouts.managernav')
                 	
                
                    <ul class="indented aside-progress-stats">
                        <li>
                            <!-- easy pie chart -->
                            <div class="easypie">
                           
                            
                                <div class="percentage" data-percent="30">
                                    <span style="">30</span>%
                                </div>
                                <div class="easypie-text">
                                <br>
                                THIS WEEKS SALES GOAL<br>
                                <h2>$5000</h2>
                                <br>
                                YOUR CURRENT SALES<br>
                                <h2 style=""></h2>
                                </div>
                            </div>
                            <!-- end easy pie chart -->
                        </li>
                    </ul>
                    <div class="divider"></div>
                </aside>
                <!-- aside end -->
                
                <!-- main content -->
                <div id="page-content" style="padding-bottom:80px;">
            
                
                    <!-- page header -->
                    <h1>Sales for Month</h1>   
                    <div class="fluid-container">

                        <div class="row-fluid">
                            <div class="span2 paybox" >
                                <h5>UNSUBMITTED</h5>
                                <div>{{count($confirms)}}</div>
                            </div>
                            <div class="span2 paybox" >
                                <h5 style="margin-left:30px;">CONFIRMED</h5>
                                <div>{{count($approvals)}}</div>
                            </div>
                            <div class="span2 paybox" >
                                 <h5 >TOTAL PAYOUT</h5>
                               <h3 style="margin-left:20px;"> ${{$statsmonth[0]->pay}}.00</h3>
                            </div>
                            <div class="span2 paybox" >
                                  <h5 style="margin-left:30px;">GROSS SALES</h5>
                               <h3 style="margin-left:20px;"> ${{$statsmonth[0]->price}}.00</h3>
                            </div>
                            
                           


                        </div>
                    <!-- start icons -->
                   
                    <!-- end start icons -->
                        
                    <!-- widget grid -->
                        <section id="widget-grid" class="">
                             <div class="row-fluid" id="saleview">
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" data-widget-togglebutton="false"  >
                                        <header>
                                            <h2>Viewing Sale # <span id="saleno"></span></h2>
                                        </header>
                                        <!-- wrap div -->
                                        <div>            
                                            <div class="inner-spacer" style="padding:40px;"> 
                                                <h4>Sale # : <Span id="saleid"></span> </h4>
                                                <p>Sold by: <b><span id="rep">Fill here</span></b></p>
                                                <p>Date Sold: <b><span id="date">Fill here</span></b></p>
                                                <p>System Type: <b><span id="system">Super System</span></b></p>
                                                <hr>
                                                <table class="table table-bordered"
                                                >
                                                    <thead>
                                                        <tr><th>ITEM SKU#</th>
                                                            <th>Date Sold</th>
                                                            
                                                           
                                                            <th>PRICE</th>
                                                                                                                    
                                                       
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody id="saledata">
                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                </div>
                            </article>
                            </div>

                        <div class="row-fluid" >
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" data-widget-togglebutton="false"  >
                                        <header>
                                            <h2>{{$your}} UN-SUBMITTED SALES</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                        
                                            <div class="inner-spacer"> 
                                                <table class="table table-striped table-bordered responsive" >
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Customer Name</th>
                                                            <th>Cust Num</th>
                                                            <th>SALES REP</th>
                                                            <th>SUBMIT DETAILS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!empty($confirms))
                                                    @foreach($confirms as $val)
                                                    <tr id="salerow-{{$val->id}}">
                                                        <td>{{date("M-d", strtotime($val->app_date))}}</td>
                                                        <td>{{$val->cust_name}} @if(!empty($val->spouse_name)) and {{$val->spouse_name}} @endif</td>
                                                        <td>{{$val->cust_num}}</td>
                                                        <td>{{$val->rep_name}}</td>
                                                        <td><center>
                                                            <a href="{{URL::to('sales/submitsale/')}}{{$val->id}}"><button class="btn btn-primary btn-small submitPayform"><i class="cus-money-dollar"></i>&nbsp;&nbsp;SUBMIT DETAILS</button></a></center></td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
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

                        <div class="row-fluid" >
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" data-widget-togglebutton="false"  >
                                        <header>
                                            <h2>{{$your}} SALES AWAITING APPROVAL</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <table class="table table-striped table-bordered responsive" >
                                                    <thead>
                                                        <tr>
                                                            <th>SUBMITTED ON</th>
                                                            <th>TYPE OF SALE</th>
                                                            <th style="width:8%;">SKU #'s</th>
                                                            <th>DEFERRAL</th>
                                                            <th>PAYMENT</th>
                                                            <th style="width:10%;">PRICE</th>
                                                            <th style="width:10%;">Payout</th>
                                                            @if(Auth::user()->user_type=="manager")
                                                            <th style="width:20%;">APPROVAL</th>
                                                            @endif
                                                            <th style="width:10%;">ACTIONS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!empty($approvals))
                                                    @foreach($approvals as $val)
                                                 
                                                    <tr id="salerow-{{$val->id}}">
                                                        <form method="post" action="{{URL::to('sales/approve/')}}{{$val->id}}" id="approvesale">
                                                        <td>   {{date("M-d", strtotime($val->submission_date))}} by<br/><span class="label label-info">{{$val->sold_by}}</span></td>
                                                        <td>{{strtoupper($val->typeofsale)}}</td>
                                                        <td>{{$val->skus}}
                                                         <td>
                                                            <select id="deferal" name="deferal" class="span12">
                                                                <option value='NA' @if($val->deferal=="NA")selected='selected'@endif>Not Applicable</option>
                                                                <option value='30day' @if($val->deferal=="30day")selected='selected'@endif>30 Day</option>
                                                                <option value='3month' @if($val->deferal=="3month")selected='selected'@endif>3 Month</option>
                                                                <option value='6month' @if($val->deferal=="6month")selected='selected'@endif>6 Month</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select id="methodofpay" name="methodofpay" class="span12">
                                                                <option value=""></option>
                                                                <option value='visa' @if($val->payment=="visa")selected='selected'@endif>VISA</option>
                                                                <option value='mastercard' @if($val->payment=="mastercard")selected='selected'@endif>MASTERCARD</option>
                                                                <option value='cheque' @if($val->payment=="cheque")selected='selected'@endif>CHEQUE</option>
                                                                <option value='cash' @if($val->payment=="cash")selected='selected'@endif>CASH</option>
                                                                <option value='lendcare' @if($val->payment=="lendcare")selected='selected' @endif>LENDCARE</option>
                                                                <option value='crelog' @if($val->payment=="crelog")selected='selected' @endif>CRELOGIX</option>
                                                                <option value='jp' @if($val->payment=="jp")selected='selected' @endif>JP FINANCIAL</option>
                                                            </select>
                                                           
                                                        </td>
                                                        <td><span>$</span><span class="edit" id="price|{{$val->id}}">{{$val->price}}</span></td>
                                                        <td><span>$</span><span class="edit" id="payout|{{$val->id}}">{{$val->payout}}</span></td>
                                                        @if(Auth::user()->user_type=="manager")<td>
                                                        <div class="span12" style="margin-left:30px;">
                                                       <label class="checkbox">
                                                        <input type="checkbox" id="net" name="net" value="1">
                                                            NET
                                                        </label>
                                                        <label class="checkbox">
                                                        <input type="checkbox" id="financed" name="financed" value="1" >
                                                            FINANCED
                                                        </label>
                                                        <label class="checkbox">
                                                        <input type="checkbox" id="app" name="app" value="1" >
                                                            APP
                                                        </label>
                                                        <label class="checkbox">
                                                        <input type="checkbox" id="tdpayout" name="tdpayout" value="1" >
                                                            TD PAYOUT
                                                        </label>
                                                        <label class="checkbox">
                                                        <input type="checkbox" id="conf" name="conf" value="1" >
                                                            CONF
                                                        </label>
                                                        <label class="checkbox">
                                                        <input type="checkbox" id="funded" name="funded" value="1"  >
                                                            FUNDED
                                                        </label>
                                                        </div>
                                                        </td>@endif
                                                        <td><center>@if(Auth::user()->user_type=="manager")
                                                       <button class="btn btn-primary btn-mini approve"><i class="cus-accept"></i>&nbsp;&nbsp;APPROVE</button></a>@endif &nbsp;&nbsp;<br/><br/>
                                                        </form>
                                                        <button class="btn btn-danger btn-mini cancelsale" data-id="{{$val->sale_id}}"><i class="cus-eye"></i>&nbsp;&nbsp;Cancel Sale</button></a></center></td>
                                                       
                                                    </tr>
                                                    @endforeach
                                                    @endif
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

                        <div class="row-fluid" style="display:none" >
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" data-widget-togglebutton="false"  >
                                        <header>
                                            <h2>{{$your}} COMPLETED SALES</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                        
                                            <div class="inner-spacer"> 
                                                <table class="table table-striped table-bordered responsive" >
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Customer Name</th>
                                                            <th>Cust Num</th>
                                                            <th>SALES REP</th>
                                                            <th>CONFIRM</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(!empty($confirms))
                                                    @foreach($confirms as $val)
                                                    <tr id="salerow-{{$val->id}}">
                                                        <td>{{date("M-d", strtotime($val->app_date))}}</td>
                                                        <td>{{$val->cust_name}}</td>
                                                        <td>{{$val->cust_num}}</td>
                                                        <td>{{$val->rep_name}}</td>
                                                        <td><center><button class="btn btn-primary btn-small"><i class="cus-money-dollar"></i>&nbsp;&nbsp;SUBMIT INFORMATION</button></center></td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
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
                     <!-- sparkline stats -->
                    <ul class="mystats indented">
                        <li class="first">
                            <h1><span>THIS WEEK:</span>${{$statsweek[0]->price}}.00</h1>
                            <div class="mychart" id="balance" style="width:35px"></div>
                        </li>
                         
                        <li >
                            <h1><span>THIS MONTH:</span>${{$statsmonth[0]->price}}.00</h1>
                            <div class="mychart" id="clicks" style="width:35px"></div>
                        </li>
                        
                    </ul>
                    <div class="divider"></div>
                    <div class="number-stats">
                        <ul>
                            <li><span>WEEK</span>7<span>sales</span></li>
                            <li><span>MONTH</span>17<span>sales</span></li>
                            <li><span>GOAL</span>25<span>sales</span></li>
                        </ul>
                    </div>
                    <div class="divider"></div>
                </aside>
                <!-- end aside right -->
            </div>
            
        </div><!--end fluid-container-->
        <div class="push"></div>
    </div>
    <!-- end .height wrapper -->
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){
$('#salesmenu').addClass('expanded');

$('.edit').editable('{{URL::to("sales/edit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK',
});

$('.cancelsale').click(function(){
if(confirm('This will return the linked machines back to stock/checked out status, and cancel this sale.\n\n ARE YOU SURE!?')){
    alert('test');
}
});

$('.viewsale').click(function(){
var id= $(this).data('id');
var url = "sales/viewsale/"+id;
   $.getJSON(url, function(data) {
    var data = data.attributes;
   	$('span#saleno').html(data.id);
    $('span#saleid').html(data.id);
    $('span#price').html(data.price);
    $('span#date').html(data.date);
    $('span#rep').html(data.sold_by);
    var sale = data.typeofsale.charAt(0).toUpperCase() + data.typeofsale.slice(1)
    $('span#system').html(sale);

    var html = "<tr><td>"+data.skus+"</td><td>"+data.date+"</td><td>"+data.price+"</td></tr>";
    $('#saledata').html(html);
    $('#saleview').hide();
    $('#saleview').fadeIn(300);
  });           
});
});
</script>
@endsection