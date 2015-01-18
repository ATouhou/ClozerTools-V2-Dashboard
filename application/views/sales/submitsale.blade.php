@layout('layouts/main')
@section('content')
      
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <!-- LEFT SIDE WIDGETS & MENU -->
        <aside> 
            @render('layouts.managernav')
       </aside>
        <!-- END WIDGETS -->
                
        <!-- MAIN CONTENT -->
        <div id="page-content" >
            <h3 id="page-header">Sold By : {{$sale->rep_name}}&nbsp;&nbsp;&nbsp;<span style="margin-left:50px;">Specialist Level : <img src="{{URL::to_asset('images/level')}}{{User::find($sale->rep)->level}}.png" width=50px></span></h3>
            
         
            <div class="fluid-container">
                
                <!-- widget grid -->
                <section id="widget-grid" class="">

                         <div class="row-fluid" id="submitnewsale">
                            <article class="span12">
                                    <!-- new widget -->
                                    <div class="jarviswidget black" data-widget-editbutton="false" data-widget-deletebutton="false"
                                    data-widget-fullscreenbutton="false" data-widget-togglebutton="false"  >
                                        <header>
                                            <h2>SUBMIT NEW PAYFORM</h2>                           
                                        </header>
                                        <!-- wrap div -->
                                        <div>
                                        
                                            <div class="inner-spacer" style="padding:20px;padding-left:50px;padding-right:50px;"> 
                                            
                                                <h4>Date of Appointment / Sale:  <span class="label label-info special">{{date('D-d M Y', strtotime($sale->app_date))}}</span></h4>
                                                    

                                                <form class="form-horizontal themed" id="payform" method="post" action="{{URL::to('sales/newsale')}}"><br/>
                                                    Customer Name : <input type="text" name="custname" id="custname" value="{{$sale->cust_name}}"/><br/><br/>
                                                <table class="table table-bordered responsive" >
                                                    <thead>
                                                        <tr>                                                         
                                                            <th>SYSTEM SOLD</th>
                                                            <th>SKUS</th>
                                                            <th>PAYMENT TYPE</th>                              
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                    
                                                    <tr>
                                                        <td>
                                                        <input type="hidden" id="lead_id" name="lead_id" value="{{$sale->id}}" />
                                                      
                                                        <select id="typeofsystem" name="typeofsystem" class="span12">
                                                            <option value='defender'>DEFENDER</option>
                                                            <option value='majestic'>MAJESTIC</option>
                                                            <option value='system'>SYSTEM</option>
                                                            <option value='supersystem'>SUPER SYSTEM</option>
                                                            <option value='megasystem'>MEGA SYSTEM</option>
                                                        </select>

                                                        </td>
                                                        <td>
                                                        <select id="skulist" name="skulist" class="span12">
                                                        <option vale=""></option>
                                                            @foreach($skus as $val)
                                                             <option value="{{$val->sku}}"># {{$val->sku}} - {{ucfirst($val->item_name)}} | {{$val->checked_by}}</option>
                                                            @endforeach
                                                        </select><br/><br/>
                                                         @if($errors->has('tags'))<span class="label label-important special">At least 1 Inventory number is Required!</span>@endif
                                                        <input id="skussale" value="" name="tags" />
                                                        </td>
                                                        <td>
                                                            @if($errors->has('methodofpay'))<span class="label label-important special">Payment Type is Required!</span>@endif
                                                            <select id="methodofpay" name="methodofpay" class="span12">
                                                                <option value=""></option>
                                                                <option value='visa'>VISA</option>
                                                                <option value='mastercard'>MASTERCARD</option>
                                                                <option value='cheque'>CHEQUE</option>
                                                                <option value='cash'>CASH</option>
                                                                <option value='lendcare'>LENDCARE</option>
                                                                <option value='crelog'>CRELOGIX</option>
                                                                <option value='jp'>JP FINANCIAL</option>
                                                            </select>
                                                            <br/><br/>
                                                            <label for="deferal">Deferal</label>
                                                            <select id="deferal" name="deferal" class="span12">
                                                                <option value='NA'>Not Applicable</option>
                                                                <option value='30day'>30 Day</option>
                                                                <option value='3month'>3 Month</option>
                                                                <option value='6month'>6 Month</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                    <thead>
                                                        <tr><th>PRICE & PAYOUT</th>
                                                            <th>PAYFORM SUBMITTED ON </th>
                                                        
                                                            <th>NOTES</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                   
                                                    <tr> <td>
                                                          @if($errors->has('price'))<span class="label label-important special">Price is Required!</span>@endif
                                                            
                                                        <label for="price">Price</label>
                                                            <input type="text" class="span7"  id="price" name="price" /><br/><br/>
                                                             @if($errors->has('payout'))<span class="label label-important special">Payout is Required!</span>@endif
                                                            <label for="price">Payout</label>
                                                            <input type="text" class="span7" id="payout" name="payout" />
                                                        </td>
                                                        <td> 
                                                            <div class="input-append date" id="datepicker-js" data-date="<?php echo date('Y-m-d');?>" data-date-format="yyyy-mm-dd">
                                                            <input class="datepicker-input" id="date" name="date" size="26" type="text" value="<?php echo date("Y-m-d");?>" placeholder="Select a date" />
                                                            <span class="add-on"><i class="cus-calendar-2"></i></span>
                                                        </div>
                                                        </td>
                                                       
                                                        <td><textarea class="span12" id="comments" name="comments" rows=4></textarea></td>
                                                    </tr>
                                                    </tbody>
                                                </table><br><br>
                                                     <button class="btn btn-default"><i class="cus-money-dollar"></i>&nbsp;&nbsp;SUBMIT DETAILS</button></form>
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
            
            <!--RIGHT SIDE WIDGETS-->
        <aside class="right">
            @render('layouts.chat')
        </aside>
        <!--END RIGHT SIDE WIDGETS-->

        </div>
        <!-- end main content -->
    </div>
</div><!--end fluid-container-->
<div class="push"></div>
<script>
$(document).ready(function(){
$('#salesmenu').addClass('expanded');

$('#skussale').tagsInput({
   'height':'100px',
   'width':'180px',
   'maxChars' : 10,
   'defaultText':'Enter SKU#s',
});

$('#skulist').change(function(){
    var sku = $(this).val();
    $('#skussale').addTag(sku);
});
});
</script>
@endsection