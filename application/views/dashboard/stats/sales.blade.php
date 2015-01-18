@layout('layouts/main')
@section('content')
<style>
table.apptable td select{width:80px;}
</style>
<div id="main" role="main" class="container-fluid">
    <div class="contained">
        <aside> 
            @render('layouts.managernav')
       </aside>
        <div id="page-content" >
            <h1 id="page-header"></h1>   

            <div class="fluid-container">
                
                <h3 style="margin-top:0px;">YOUR CURRENT SALES AWAITING SERIAL NUMBERS AND PAYMENT DETAILS</h3>
                <div class='row-fluid well animated fadeInUp' style="background:#FFFFEB">
                    <table class="table apptable table-condensed">
                        <thead>
                            <tr>
                               
                                <th style="width:4%;">Date</th>
                                <th>Customer Name</th>
                                <th style="width:7%;"><span class="small">Phone #</span></th>
                                <th>Payment</th>
                                <th>System Type</th>
                                <th>MAJ#360</th>
                                <th>DEF#360</th>
                                <th>DEF2#360</th>
                                <th>ATT#360</th>
                                <th>Notes</th>
                                <th>COMMISION</th>
                                <th>PRICE</th>
                                <th>SUBMIT</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @foreach($salesreport as $val)
                        <?php $sale = Sale::find($val->id);?>
                            <tr>
                                <td><span class="small">{{date('D d',strtotime($val->date))}}</span></td>
                                <td><span class="edit" id="cust_name|{{$val->id}}">{{$val->cust_name}}</span></span></td>
                                <td>{{$sale->lead->cust_num}}</td>
                                <td><span class="edit" id="payment|{{$val->id}}">@if(!empty($val->payment)){{$val->payment}} @endif</span></td>
                                <td><span class="systemedit" id="typeofsale|{{$val->id}}">{{ucfirst($val->typeofsale)}}</span></td>
                                <td>
                                    @if(!empty($val->maj)){{Inventory::find($val->maj)->sku}} 
                                        <a href="{{URL::to('sales/removeitem')}}/{{$val->maj}}-maj"><i class="cus-cancel"></i></a>
                                    @else 
                                        <span class="editinv" id="maj|{{$val->id}}" data-rep="{{$sale->sold_by}}" data-type='majestic'><span class='label label-important'>Select SKU</span ></span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($val->defone)){{Inventory::find($val->defone)->sku}} 
                                        <a href="{{URL::to('sales/removeitem')}}/{{$val->defone}}-defone"><i class="cus-cancel"></i></a>
                                    @else 
                                        <span class="editinv" id="defone|{{$val->id}}" data-rep="{{$sale->sold_by}}" data-type='defender'><span class='label label-important'>Select SKU</  span></span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($val->deftwo)){{Inventory::find($val->deftwo)->sku}} 
                                        <a href="{{URL::to('sales/removeitem')}}/{{$val->deftwo}}-deftwo"><i class="cus-cancel"></i></a>
                                    @else 
                                        <span class="editinv" id="deftwo|{{$val->id}}" data-rep="{{$sale->sold_by}}" data-type='defender'><span class='label label-important'>Select SKU</span></span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($val->att)){{Inventory::find($val->att)->sku}} 
                                        <a href="{{URL::to('sales/removeitem')}}/{{$val->att}}-att"><i class="cus-cancel"></i></a>
                                    @else 
                                        <span class="editinv" id="att|{{$val->id}}" data-rep="{{$sale->sold_by}}" data-type='attachment'><span class='label label-important'>Select SKU</span></span>
                                    @endif
                                </td>
                                <td><span class="edit" id="comments|{{$val->id}}">{{$val->comments}}</span></td>
                                <td><span class="edit" id="payout|{{$val->id}}">@if(!empty($val->payout)){{number_format($val->payout,2,'.','')}}@endif</span></td>
                                <td><span class="edit" id="price|{{$val->id}}">@if(!empty($val->price)){{number_format($val->price,2,'.','')}}@endif</span></td>
                                <td><button class='btn btn-primary'>SUBMIT</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <h3 style="margin-top:0px;">YOUR COMPLETED DEALS THIS MONTH</h3>
                <div class='row-fluid well animated fadeInUp' style="background:#D6FFEB">
                    <table class="table apptable table-condensed">
                        <thead>
                            <tr>
                                <th style="width:4%;">Date</th>
                                <th>Customer Name</th>
                                <th style="width:7%;"><span class="small">Phone #</span></th>
                                <th>Payment</th>
                                <th>System Type</th>
                                <th>MAJ#360</th>
                                <th>DEF#360</th>
                                <th>DEF2#360</th>
                                <th>ATT#360</th>
                                <th>Notes</th>
                                <th>PAYOUT</th>
                                <th>PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $count=1;?>
                        @foreach($salesreport as $val)
                        <?php $sale = Sale::find($val->id);?>
                            <tr>
                                <td><span class="small">{{date('D d',strtotime($val->date))}}</span></td>
                                <td>{{$val->cust_name}}</td>
                                <td>{{$sale->lead->cust_num}}</td>
                                <td>{{$val->payment}}</td>
                                <td>{{ucfirst($val->typeofsale)}}</td>
                                <td>
                                    @if(!empty($val->maj)){{Inventory::find($val->maj)->sku}} 
                                        {{Inventory::find($val->maj)->sku}}
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($val->defone)){{Inventory::find($val->defone)->sku}} 
                                        {{Inventory::find($val->defone)->sku}}
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($val->deftwo)){{Inventory::find($val->deftwo)->sku}} 
                                        {{Inventory::find($val->deftwo)->sku}}
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($val->att)){{Inventory::find($val->att)->sku}} 
                                        {{Inventory::find($val->att)->sku}}
                                    @endif
                                </td>
                                <td>{{$val->comments}}</td>
                                <td>@if(!empty($val->payout)){{number_format($val->payout,2,'.','')}}@endif</td>
                                <td>@if(!empty($val->price)){{number_format($val->price,2,'.','')}}@endif</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>





                
                <h3>Your Sales for {{$title}}  
                    <button class="btn btn-inverse" style="float:right;margin-right:3px;margin-top:5px;" onclick="$('#stats').toggle(400);">
                        <i class="cus-chart-bar"></i>&nbsp;VIEW STATS
                    </button>
                </h3>
                <div class="well row-fluid">
                    <form method="post" action="" id="dates" name="dates"/>
                        FROM : 
                        <div class="input-append date" style="margin-top:5px;" id="datepicker-js" data-date="{{$startdate}}" data-date-format="yyyy-mm-dd">
                            <input class="datepicker-input" size="16" id="startdate" name="startdate" type="text" value="{{$startdate}}" placeholder="Select a date" />
                            <span class="add-on"><i class="cus-calendar-2"></i></span>
                        </div>
                        &nbsp;&nbsp;TO : 
                        <div class="input-append date" style="margin-top:5px;" id="datepicker-js" data-date="{{$enddate}}" data-date-format="yyyy-mm-dd">
                            <input class="datepicker-input" size="16" id="enddate" name="enddate" type="text" value="{{$enddate}}" placeholder="Select a date" />
                            <span class="add-on"><i class="cus-calendar-2"></i></span>
                        </div>
                        <button class="btn btn-default" style="margin-left:20px;margin-top:-6px;">
                            <i class="cus-application-view-tile"></i>&nbsp;GENERATE REPORT
                        </button>
                    </form>
                </div>
               

                <div class="row-fluid well" style="margin-top:20px;">
                    <div class="largestats end ">
                        <span class="bignum2 BOOK"></span><br/>
                        <h5>COMPLETED</h5>
                    </div>
                    <div class="largestats end ">
                        <span class="bignum2 PUTON"></span><br/>
                        <h5>VALID</h5>
                    </div>
                    <div class="largestats end ">
                        <span class="bignum2 DNS2"></span><br/>
                        <h5>WRONG</h5>
                    </div>
                    <div class="largestats end">
                        <span class="bignum2 RECALL">$</span><br/>
                        <h5>GROSS (including Wrong #'s)</h5>
                    </div>
                     <div class="largestats end">
                        <span class="bignum2 SOLD">$</span><br/>
                        <h5>NET For {{$title}}</h5>
                    </div>
                </div>

                <div class='row-fluid'>
                    <table class="table apptable table-condensed">
                        <thead>
                            <tr>
                                <th style="width:1%"></th>
                                <th style="width:4%;">Date</th>
                                <th>Customer Name</th>
                                <th style="width:7%;"><span class="small">Phone #</span></th>
                                <th>Payment</th>
                                <th>System Type</th>
                                <th>MAJ#360</th>
                                <th>DEF#360</th>
                                <th>DEF2#360</th>
                                <th>ATT#360</th>
                                <th>Notes</th>
                                <th>PAYOUT</th>
                                <th>PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $count=1;?>
                        @foreach($salesreport as $val)
                        <?php $sale = Sale::find($val->id);?>
                            <tr>
                                <td>{{$count++}}</td>
                                <td><span class="small">{{date('D d',strtotime($val->date))}}</span></td>
                                <td><span class="edit" id="cust_name|{{$val->id}}">{{$val->cust_name}}</span></span></td>
                                <td>{{$sale->lead->cust_num}}</td>
                                <td><span class="edit" id="payment|{{$val->id}}">@if(!empty($val->payment)){{$val->payment}} @endif</span></td>
                                <td><span class="systemedit" id="typeofsale|{{$val->id}}">{{ucfirst($val->typeofsale)}}</span></td>
                                <td>
                                    @if(!empty($val->maj)){{Inventory::find($val->maj)->sku}} 
                                        <a href="{{URL::to('sales/removeitem')}}/{{$val->maj}}-maj"><i class="cus-cancel"></i></a>
                                    @else 
                                        <span class="editinv" id="maj|{{$val->id}}" data-rep="{{$sale->sold_by}}" data-type='majestic'><span class='label label-important'>Select SKU</span ></span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($val->defone)){{Inventory::find($val->defone)->sku}} 
                                        <a href="{{URL::to('sales/removeitem')}}/{{$val->defone}}-defone"><i class="cus-cancel"></i></a>
                                    @else 
                                        <span class="editinv" id="defone|{{$val->id}}" data-rep="{{$sale->sold_by}}" data-type='defender'><span class='label label-important'>Select SKU</  span></span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($val->deftwo)){{Inventory::find($val->deftwo)->sku}} 
                                        <a href="{{URL::to('sales/removeitem')}}/{{$val->deftwo}}-deftwo"><i class="cus-cancel"></i></a>
                                    @else 
                                        <span class="editinv" id="deftwo|{{$val->id}}" data-rep="{{$sale->sold_by}}" data-type='defender'><span class='label label-important'>Select SKU</span></span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($val->att)){{Inventory::find($val->att)->sku}} 
                                        <a href="{{URL::to('sales/removeitem')}}/{{$val->att}}-att"><i class="cus-cancel"></i></a>
                                    @else 
                                        <span class="editinv" id="att|{{$val->id}}" data-rep="{{$sale->sold_by}}" data-type='attachment'><span class='label label-important'>Select SKU</span></span>
                                    @endif
                                </td>
                                <td><span class="edit" id="comments|{{$val->id}}">{{$val->comments}}</span></td>
                                <td><span class="edit" id="payout|{{$val->id}}">@if(!empty($val->payout)){{number_format($val->payout,2,'.','')}}@endif</span></td>
                                <td><span class="edit" id="price|{{$val->id}}">@if(!empty($val->price)){{number_format($val->price,2,'.','')}}@endif</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                      
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
<script src="{{URL::to_asset('js/include/guage.min.js')}}"></script>
<script src="{{URL::to_asset('js/editable.js')}}"></script>
<script>
$(document).ready(function(){

$('.editinv').editable('{{URL::to("sales/additem")}}', {
        data: function(value, settings){
            rep = $(this).data('rep');
            machine = $(this).data('type');
            $.ajax({
                url:'../dashboard/getmachinelist',
                type:'get',
                dataType: 'json',
                async:false,
                data: {rep:rep,type:machine},
                success: function(data){
                result = data;
                console.log(data);
                    }
                });
                return result;
        },
            type    : 'select',
            submit  : 'OK',
            width : '40'
    });

    $('.edit').editable('{{URL::to("sales/edit")}}',{
        submit:'OK',
            indicator : 'Saving...',
            tooltip: 'Enter Data',
            width:'100',
            placeholder:".................."
    });

    $('.systemedit').editable('{{URL::to("sales/edit")}}',{
        data : '{"defender":"Defender","majestic":"Majestic","system":"System","supersystem":"Super System","megasystem":"Mega System"}',
        type: 'select',
        submit:'OK',
        indicator: 'saving',
        tooltip: 'Select',
    });
});
</script>


<Script>
$(document).ready(function(){



$(".booktimepicker2").timePicker({
  startTime: "10:00", 
  endTime: new Date(0, 0, 0, 23, 30, 0), 
  show24Hours: false,
  step: 15});
});



</script>
@endsection