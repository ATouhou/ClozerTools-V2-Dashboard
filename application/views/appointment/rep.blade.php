@layout('layouts/main')
@section('content')

        
<style>
#processapp {display:none;}
</style>
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- aside -->  
        <aside> 
            <!--MENU-->
            @render('layouts.managernav')
                <div class="number-stats">
                    <center><h4>Numbers for Period</h4></center>
                    <ul>
                        <li>
                             @if(!empty($appts))
                            {{count($appts)}}@endif
                            <span>Demos</span>
                        </li>
                        <li>
                            @if(!empty($sold))
                            {{$sold}}@endif
                            <span>Sold</span>
                        </li>
                        <li>@if(!empty($appts))
                            <?$close = round(($sold/count($appts)*100),2);?>
                            {{$close}}@endif
                            <span>Close %</span>
                        </li>
                    </ul>
                </div>
                <div class="divider"></div>
        </aside>
        <!-- aside end -->
                
        <div id="page-content">
           
                <h1 id="page-header" data-date="{{$datepass}}">Your Demos for {{$date}}</h1>   
                    <div class="fluid-container">
 
                        <!-- widget grid -->
                        <section id="widget-grid" >

                            <div class="row-fluid" id="processapp">
                                <article class="span12" style="margin-bottom:40px;">
                                <h2><span id="processhead">Process this Appointment</span></h2>
                                    <form id="processform" method="post" action="{{URL::to('appointment/repprocess')}}">
                                        <div class="control-group">
                                            <h3>What was the result of this demo?</h3>
                                            <label class="control-label">Choose a New Status</label>
                                                <div class="controls">
                                                    <div class="btn-group" data-toggle="buttons-radio">
                                                                                                                
                                                        <button type="button" class="btn btn-small process sold " data-status="SOLD">
                                                            <i class="cus-emoticon-grin"></i>&nbsp;SOLD
                                                        </button>
                                                        <button type="button" class="btn btn-small process" data-status="DNS">
                                                            <i class="cus-emoticon-unhappy"></i>&nbsp;DNS
                                                        </button>
                                                        <button type="button" class="btn btn-small process" data-status="CXL">
                                                            <i class="cus-delete"></i>&nbsp;CXL
                                                        </button>
                                                        <button type="button" class="btn btn-small process" data-status="NQ">
                                                            <i class="cus-cross"></i>&nbsp;NQ
                                                        </button>
                                                         <button type="button" class="btn btn-small process" data-status="INC">
                                                            <i class="cus-plug"></i>&nbsp;INC
                                                        </button>
                                                    </div>
                                                </div>
                                                <form class="form-horizontal themed" id="payform" method="post" action="{{URL::to('sales/newsale')}}">
                                            <input type="hidden" name="result" id="result" value="" />

                                    <article id="submitpayform">
                                    <h2 class="shadow">Congratulations, Please Enter the details...</h4>
                                    <hr style="border:1px dashed #ddd">
                                    
                                        <fieldset>
                                            <h4>Type of Sale</h4>
                                            <div class="controls">
                                                <select id="typeofsystem" name="typeofsystem" class="span12">
                                                     <option value='defender'>DEFENDER</option>
                                                     <option value='majestic'>MAJESTIC</option>
                                                     <option value='system'>SYSTEM</option>
                                                     <option value='supersystem'>SUPER SYSTEM</option>
                                                     <option value='megasystem'>MEGA SYSTEM</option>
                                                </select>
                                            </div>
                                            <hr style="border:1px dashed #ddd">

                                            <h4>SKU #'s</h4>
                                            <div class="controls">
                                                <label class="control-label" for="input01"><b>PICK SYSTEM SKU'S</b></label>
                                                 <select id="skulist" name="skulist" class="span2">
                                                     <option vale=""></option>
                                                     @foreach($skus as $val)
                                                     <option value="{{$val->sku}}"># {{$val->sku}}</option>
                                                     @endforeach
                                                </select>
                                            <div class="controls" style="margin-bottom:40px;">
                                                <input id="skussale" value="" name="tags" />
                                            </div>
                             
                                            <h4>Method of Payment</h4>
                                            <div class="controls">
                                                <select id="methodofpay" name="methodofpay" class="span12">
                                                    <option value='visa'>VISA</option>
                                                    <option value='mastercard'>MASTERCARD</option>
                                                    <option value='cheque'>CHEQUE</option>
                                                    <option value='cash'>CASH</option>
                                                    <option value='lendcare'>LENDCARE</option>
                                                    <option value='crelog'>CRELOGIX</option>
                                                    <option value='jp'>JP FINANCIAL</option>
                                                </select>
                                            </div>
                                            <h4>Deferal</h4>
                                            <div class="controls">
                                                <select id="deferal" name="deferal" class="span12">
                                                    <option value='NA'>Not Applicable</option>
                                                    <option value='30day'>30 Day</option>
                                                    <option value='3month'>3 Month</option>
                                                    <option value='6month'>6 Month</option>
                                                </select>
                                            </div>
                             
                                            <h4>Sale Information</h4>
                                            <input type="hidden" class="span12"  id="lead-id" name="lead-id" value="" />
                                            <div class="controls">
                                                <label class="control-label" for="input01">Price</label>
                                                <div class="controls">
                                                    <input type="text" class="span5"  id="price" name="price" />
                                                </div>
                                            </div>
                                            <div class="controls">
                                                <label class="control-label" for="input01">Payout</label>
                                                <div class="controls">
                                                    <input type="text" class="span5"  id="payout" name="payout" />
                                                </div>
                                            </div>
                                                                    
                                            <div class="controls">
                                                <label class="control-label">Options</label>
                                                <div class="controls">
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
                                            </div>
                                        </fieldset>
                                    </article>
                                            <div class="controls" style="margin-top:20px;">
                                            <label class="control-label" for="input01"><b>Enter Notes</b></label>
                                                <div class="controls">
                                                    
                                                    <textarea rows=4 cols=9 name="notes" id="notes"></textarea>
                                                </div>
                                            </div>
                                       
                                            
                                        </div>
                                        <div class="control-group">
                                            <button class="btn btn-inverse"><i class="cus-arrow-right"></i>&nbsp;&nbsp;PROCESS THIS DEMO</button>
                                            <a href="javascript:void();"class="btn" onclick="$('#processapp').hide(150);"><i class="cus-cross"></i>&nbsp;&nbsp;CANCEL</a>
                                        </div>
                                    </form>
                                </article>
                            </div>



                            <div class="row-fluid" id="appointments">
                            <!-- new widget -->
                                <div class="jarviswidget" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" >
                                    <header>
                                        <h2>Appointment Board</h2>                           
                                    </header>
                                        <!-- wrap div -->
                                        <div>
                                            <div class="inner-spacer"> 
                                                <table class="table table-bordered responsive"  >
                                                    <thead>
                                                        <tr>
                                                            <th>TIME</th>
                                                            <th>Name</th>
                                                            <th>Number</th>
                                                            <th>Address</th>
                                                            <th>Gift</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                     @foreach($appts as $val)
                                                    
                                              

                                                        <tr class="{{$val->result}}" style="color:#1f1f1f">
                                                            <td><b>{{date('H:m', strtotime($val->app_time))}}</b></td>
                                                            <td>{{ucfirst($val->cust_name)}}</td>
                                                            <td>{{$val->cust_num}}</td>
                                                            <td>{{$val->address}},{{$val->city}}</td>
                                                            <td>{{ucfirst($val->gift)}}</td>
                                                            <td>&nbsp;&nbsp;&nbsp;
                                                                <button class="btn btn-primary btn-mini processappt" data-id="{{$val->id}}">
                                                                    <i class="icon-pencil"></i> PROCESS
                                                                </button>
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
                        

                            
                            <div class="row-fluid" id="googlemaps">
                            <!-- new widget -->
                                <div class="jarviswidget" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" >
                                    <header>
                                       <h2>YOUR DEMO LOCATIONS</h2>                           
                                    </header>
                                    <div>
                                        <div class="inner-spacer" > 
                                            <div id="map" style="width:100%;height:500px;"></div>
                                        </div>
                                    </div>
                                </div>
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
            <div id="filterdate" style="background:#1f1f1f;"></div>
            <!-- end date picker -->
        </aside>

    </div>
            
</div><!--end fluid-container-->
   
<script src="{{URL::to_asset('js/include/gmap3.min.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>

<script>
$(document).ready(function(){

$('.processappt').click(function(){
var id = $(this).data('id');
$('#lead-id').val(id);
$('#processapp').fadeIn(1200);
});

$('.process').click(function(){
    var stat = $(this).data('status');
    $('#result').val(stat);
    if(stat=="SOLD"){
        $('#submitpayform').fadeIn(200);
    } else {
        $('#submitpayform').fadeOut(200);
    }
});
var date = $('#page-header').data('date');
var url = "../../appointment/getmap/{{Auth::user()->id}}?date="+date;
$.getJSON(url, function(data) {

if (data != '') {

    $("#map").gmap3({
     marker:{
       values: data,
        options:{
        draggable: false
     },
    events:{
      mouseover: function(marker, event, context){
        var map = $(this).gmap3("get"),
          infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.open(map, marker);
          infowindow.setContent(context.data);
        } else {
          $(this).gmap3({
            infowindow:{
              anchor:marker, 
              options:{content: context.data}
            }
          });
        }
      },
      mouseout: function(){
        var infowindow = $(this).gmap3({get:{name:"infowindow"}});
        if (infowindow){
          infowindow.close();
        }
      }
    }
  },
  map:{
    options:{

      zoom: 14
    }
  }
});
}
});

});
</script>

@endsection