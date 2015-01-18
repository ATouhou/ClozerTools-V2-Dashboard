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
            <h1 id="page-header"></h1>   
            <div class="fluid-container">
                
                <h3>Your Reggies for {{$title}}  <button class="btn btn-inverse" style="float:right;margin-right:3px;margin-top:5px;" onclick="$('#reggiemap').toggle(400);"><i class="cus-map"></i>&nbsp;VIEW MAP OF PERIOD</button><button class="btn btn-inverse" style="float:right;margin-right:3px;margin-top:5px;" onclick="$('#stats').toggle(400);"><i class="cus-chart-bar"></i>&nbsp;VIEW STATS</button>
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
                        <button class="btn btn-default" style="margin-left:20px;margin-top:-6px;"><i class="cus-application-view-tile"></i>&nbsp;GENERATE REPORT</button>
                        </form>
                    </div>

                    @if(!empty($total))
                    <div class="row-fluid well" id="stats" style="display:none;">
                            <div class="span4">
                                <h5>BOOK PERCENTAGE</h5>
                                <?php if(($total[0]->total!=0)||($total[0]->puton!=0)){$valu=($total[0]->puton/$total[0]->total)*100;}else {$valu=0;};?>
                                <div class="guagechart" style="width:170px;height:100px;float:left;margin-left:0px;">
                                    <canvas id="book" data-value="{{$valu}}" style="width:93%;"></canvas>
                                </div><br/>
                                <span class="badge badge-info special" style="font-size:25px;padding:10px;"><span id="spanbook"></span>&nbsp;%</span>
                            </div>
                            <div class="span4">
                                <h5>SALE PERCENTAGE</h5>
                                  <?php if(($total[0]->puton!=0)||($total[0]->sold!=0)){$valu=($total[0]->sold/$total[0]->puton)*100;}else {$valu=0;};?>
                                <div class="guagechart" style="width:170px;height:100px;float:left;margin-left:0px;">
                                    <canvas id="sales"  data-value="{{$valu}}" style="width:93%;"></canvas>
                                </div><br/>
                                <span class="badge badge-success special" style="font-size:25px;padding:10px;"><span id="spansales"></span>&nbsp;%</span>
                            </div>
                            <div class="span4">
                                <h5>WRONG # PERCENT</h5>
                                <?php if(($total[0]->total!=0)||($total[0]->wrong!=0)){$valu=($total[0]->wrong/$total[0]->total)*100;}else {$valu=0;};?>
                                <div class="guagechart" style="width:170px;height:100px;float:left;margin-left:0px;">
                                    <canvas id="wrong" data-value="{{$valu}}" style="width:93%;"></canvas>
                                </div><br/>
                                <span class="badge badge-warning special" style="font-size:25px;padding:10px;"><span id="spanwrong"></span>&nbsp;%</span>
                            </div>
                    </div>

                    <div class="row-fluid well" style="margin-top:20px;">
                            <div class="largestats end ">
                                <span class="bignum2 BOOK">{{$total[0]->total}}</span><br/>
                                <h5>COMPLETED</h5>
                            </div>
                            <div class="largestats end ">
                                <span class="bignum2 PUTON">{{$total[0]->valid}}</span><br/>
                                <h5>VALID</h5>
                            </div>
                            <div class="largestats end ">
                                <span class="bignum2 DNS2">{{$total[0]->wrong}}</span><br/>
                                <h5>WRONG</h5>
                            </div>
                            <div class="largestats end">
                                <span class="bignum2 RECALL">${{number_format(($total[0]->total*3),2,'.','')}}</span><br/>
                                <h5>GROSS (including Wrong #'s)</h5>
                            </div>
                             <div class="largestats end">
                                <span class="bignum2 SOLD">${{number_format(($total[0]->valid*3),2,'.','')}}</span><br/>
                                <h5>NET For {{$title}}</h5>
                            </div>
                    </div>
                    @endif
              
                        
                        <div id="reggiemap" class="row-fluid well" style="margin-top:30px;display:none;" >
                                <div id="maptwo" style="height:600px;width:100%;"></div>
                        </div>

                        <div class="row-fluid" style="margin-top:30px;margin-bottom:40px;">
                            <div class="span12">
                                <h4>You can edit a lead by clicking on a field  (*)</h4>
                                <span class="small">* Only if the lead has a status of UNRELEASED or WRONG NUMBER</span>
                                <table class="table apptable" >
                                    <thead>
                                        <tr style="background:#1f1f1f;color:#fff;">
                                            <th style="width:12%;">Survey</th>
                                            <th style="width:6%;">Entry</th>
                                            <th>Name</th>
                                            <th>Number</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['leads'] as $val)
                                        <?php if($val->status=="APP"){$shadow="shadowtable";$color="#000";} else {$shadow="";$color="black";}
                                                            if($val->status=="APP"){$label="success";$msg = "DEMO BOOKED!";}
                                                            elseif($val->status=="INACTIVE"){$label="inverse";$msg="UNRELEASED";}
                                                            elseif($val->status=="NEW"){$label="info";$msg="IN POOL";}
                                                            elseif($val->status=="SOLD"){$label="success special";$msg = " $$ SOLD $$";}
                                                            elseif($val->status=="ASSIGNED"){$label="info";$msg = "ASSIGNED TO CALL";} 
                                                            elseif($val->status=="NH") {$label="inverse";$msg = "NOT HOME";} 
                                                            elseif($val->status=="DNC") {$label="important special";$msg = "DO NOT CALL!";}
                                                            elseif($val->status=="NI") {$label="important";$msg = "NOT INTERESTED";}
                                                            elseif($val->status=="Recall") {$label="warning";$msg = "RECALL";} elseif($val->status=="NQ") {$label="important special";$msg = "NOT QUALIFIED";} elseif($val->status=="WrongNumber"){$label="warning special boxshadow";$msg="Wrong Number";} else{$label="";$msg="";} ?>
                                        <tr>
                                        <td>@if(($val->status=='INACTIVE')||($val->status=='WrongNumber'))
                                            <div class="input-append date changeDate" id="datepicker-js" data-id="entry_date|{{$val->id}}" data-date="{{date('d-m-Y',strtotime($val->entry_date))}}" data-date-format="dd-mm-yyyy">
                                                <input class="datepicker-input" size="11" type="text" style="float:left;width:70px;" value="{{date('d-m-Y',strtotime($val->entry_date))}}" placeholder="Select a date" name="surveydate" id="surveydate"/>
                                                <span class="add-on"><i class="cus-calendar-2"></i></span>
                                            </div>
                                            @else 
                                            {{date('M-d',strtotime($val->entry_date))}}
                                            @endif
                                        </td>
                                        <td>{{date('M d',strtotime($val->created_at))}}</td>
                                        <td @if(($val->status=='INACTIVE')||($val->status=='WrongNumber')) class="edit" id="cust_name|{{$val->id}}" @endif>{{$val->cust_name}}</td>
                                        <td @if(($val->status=='INACTIVE')||($val->status=='WrongNumber')) class="edit" id="cust_num|{{$val->id}}" @endif>{{$val->cust_num}}</td>
                                        <td @if(($val->status=='INACTIVE')||($val->status=='WrongNumber')) class="edit" id="address|{{$val->id}}" @endif>{{$val->address}}</td>
                                        <td><center><span class='label label-{{$label}} '>{{$msg}}</span></center></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
$('.edit').editable('{{URL::to("lead/edit")}}',{
 indicator : 'Saving...',
         tooltip   : 'Click to edit...',
         submit  : 'OK',
});

$('.changeDate').change(function(){
      var t = $(this).data('id');
      var val = $(this).find('input').val();
      $.get('../../lead/edit',{id:t,value:val}, function(data){
        toastr.success('Date updates succesfully!', 'DATE UPDATED');
      });
});


});
</script>
<script>
function getguageslim(gval, element, max, textfield){
var opts = {
  lines: 12, 
  angle: 0,
  lineWidth: 0.27, 
  pointer: {
    length: 1, 
    strokeWidth: 0.064, 
    color: '#000000'
  },
  limitMax: 'true',   

  colorStart: '#002906',  
  colorStop: '#00DA41',    
  strokeColor: '#E0E0E0',  
  generateGradient: true
};
var target = document.getElementById(element); 
var gauge = new Gauge(target).setOptions(opts); 
gauge.maxValue = max; 
gauge.animationSpeed = 32; 
gauge.set(gval); 
gauge.setTextField(document.getElementById(textfield));
}
</script>

<Script>
$(document).ready(function(){

var sales = $('#sales').data('value');
getguageslim(sales, 'sales', 100,'spansales');
var wrongval = $('#wrong').data('value');
getguageslim(wrongval, 'wrong', 100,'spanwrong');
var bookval = $('#book').data('value');
getguageslim(bookval, 'book', 100,'spanbook');

$(".booktimepicker2").timePicker({
  startTime: "10:00", 
  endTime: new Date(0, 0, 0, 23, 30, 0), 
  show24Hours: false,
  step: 15});
});



</script>
@endsection